<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Mostrar listado de citas.
     */
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $appointments = Appointment::with([
    'client',
    'vehicle',
    'mechanic'
])
    ->when($buscar, function ($query) use ($buscar) {

        $query->where(function ($q) use ($buscar) {

            $q->where('folio', 'like', "%{$buscar}%")

                ->orWhereHas('client', function ($clientQuery) use ($buscar) {
                    $clientQuery->where('name', 'like', "%{$buscar}%");
                })

                ->orWhereHas('vehicle', function ($vehicleQuery) use ($buscar) {
                    $vehicleQuery
                        ->where('brand', 'like', "%{$buscar}%")
                        ->orWhere('model', 'like', "%{$buscar}%");
                });

        });

    })
    ->latest()
    ->get();

$mechanics = User::where('rol', 'mecanico')
    ->orderBy('name')
    ->get();

        return view(
            'admin.citas.index',
            compact('appointments', 'buscar', 'mechanics')
        );
    }

    /**
     * Mostrar formulario para crear cita desde Admin.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();

    $mechanics = User::where('rol', 'mecanico')
        ->orderBy('name')
        ->get();

    return view(
        'admin.citas.create',
        compact('clients', 'mechanics')
    );
}


    /**
     * Guardar cita creada desde Admin.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'client_id' => [
                'required',
                'exists:clients,id'
            ],

            'vehicle_id' => [
                'required',
                'exists:vehicles,id'
            ],

            'service_type' => [
                'required',
                'string',
                'max:255'
            ],

            'appointment_date' => [
                'required',
                'date'
            ],

            'appointment_time' => [
                'required'
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000'
            ],

            'mechanic_id' => [
            'nullable',
            'exists:users,id'
            ],

        ]);

        

        if (
    !empty($validated['mechanic_id']) &&
    !User::where('id', $validated['mechanic_id'])
        ->where('rol', 'mecanico')
        ->exists()
) {
    return back()
        ->withErrors([
            'mechanic_id' => 'El usuario seleccionado no es un mecánico.'
        ])
        ->withInput();
}

        /*
         * Comprobar que el vehículo seleccionado
         * realmente pertenece al cliente.
         */
        $vehicle = Vehicle::where('id', $validated['vehicle_id'])
            ->where('client_id', $validated['client_id'])
            ->firstOrFail();

            

        $appointment = Appointment::create([

            'client_id' => $validated['client_id'],

            'vehicle_id' => $vehicle->id,

            'mechanic_id' => $validated['mechanic_id'] ?? null,

            'service_type' => $validated['service_type'],

            'appointment_date' => $validated['appointment_date'],

            'appointment_time' => $validated['appointment_time'],

            'notes' => $validated['notes'] ?? null,

            'status' => 'pendiente',

        ]);


        /*
         * Generar folio usando el ID.
         *
         * Ejemplo:
         * AM-2026-000015
         */
        $appointment->folio =
            'AM-' .
            now()->format('Y') .
            '-' .
            str_pad(
                $appointment->id,
                6,
                '0',
                STR_PAD_LEFT
            );

        $appointment->save();


        return redirect()
            ->route('citas.index')
            ->with(
                'success',
                'Cita creada correctamente'
            );
    }


    /**
     * Mostrar una cita.
     */
    public function show(Appointment $appointment)
    {
        //
    }


    /**
     * Mostrar formulario para editar cita.
     */
    public function edit(Appointment $cita)
{
    $clients = Client::orderBy('name')->get();

    $mechanics = User::where('rol', 'mecanico')
        ->orderBy('name')
        ->get();

    $cita->load([
        'client',
        'vehicle',
        'mechanic'
    ]);

    return view(
        'admin.citas.edit',
        compact('cita', 'clients', 'mechanics')
    );
}

    /**
     * Actualizar cita desde Admin.
     */
    public function update(
        Request $request,
        Appointment $cita
    ) {
        $validated = $request->validate([

            'client_id' => [
                'required',
                'exists:clients,id'
            ],

            'vehicle_id' => [
                'required',
                'exists:vehicles,id'
            ],

            'service_type' => [
                'required',
                'string',
                'max:255'
            ],

            'appointment_date' => [
                'required',
                'date'
            ],

            'appointment_time' => [
                'required'
            ],

            'notes' => [
                'nullable',
                'string',
                'max:1000'
            ],

            'mileage' => [
                'nullable',
                'integer',
                'min:0'
            ],

            'mechanic_id' => [
            'nullable',
            'exists:users,id'
            ],

        ]);

        if (
    !empty($validated['mechanic_id']) &&
    !User::where('id', $validated['mechanic_id'])
        ->where('rol', 'mecanico')
        ->exists()
) {
    return back()
        ->withErrors([
            'mechanic_id' => 'El usuario seleccionado no es un mecánico.'
        ])
        ->withInput();
}

        /*
         * Verificar que el vehículo pertenezca
         * al cliente seleccionado.
         */
        $vehicle = Vehicle::where(
                'id',
                $validated['vehicle_id']
            )
            ->where(
                'client_id',
                $validated['client_id']
            )
            ->firstOrFail();


        /*
         * Actualizar cita.
         */
        $cita->update([

            'client_id' => $validated['client_id'],

            'vehicle_id' => $validated['vehicle_id'],

            'service_type' => $validated['service_type'],

            'appointment_date' => $validated['appointment_date'],

            'appointment_time' => $validated['appointment_time'],

            'notes' => $validated['notes'] ?? null,

            'mechanic_id' => $validated['mechanic_id'] ?? null,

        ]);


        /*
         * Actualizar kilometraje del vehículo,
         * solamente si se recibió.
         */
        if ($request->filled('mileage')) {

            $vehicle->update([
                'mileage' => $validated['mileage']
            ]);

        }


        return redirect()
            ->route('citas.index')
            ->with(
                'success',
                'Cita actualizada correctamente.'
            );
    }


    /**
 * Actualizar el estado de una cita.
 */
public function updateStatus(Request $request, Appointment $cita)
{
    $validated = $request->validate([
        'status' => [
            'required',
            'in:pendiente,diagnostico,en_proceso,control_calidad,listo'
        ],
    ]);

    $cita->update([
        'status' => $validated['status'],
    ]);

    return redirect()
        ->route('citas.index')
        ->with('success', 'Estado de la cita actualizado correctamente.');
}

/**
 * Asignar o cambiar el mecánico de una cita.
 */
public function updateMechanic(Request $request, Appointment $cita)
{
    $validated = $request->validate([
        'mechanic_id' => [
            'nullable',
            'exists:users,id'
        ],
    ]);

    // Si se seleccionó un mecánico,
    // verificar que realmente tenga rol de mecánico.
    if (
        !empty($validated['mechanic_id']) &&
        !User::where('id', $validated['mechanic_id'])
            ->where('rol', 'mecanico')
            ->exists()
    ) {
        return back()
            ->withErrors([
                'mechanic_id' => 'El usuario seleccionado no es un mecánico.'
            ])
            ->withInput();
    }

    $cita->update([
        'mechanic_id' => $validated['mechanic_id'] ?? null,
    ]);

    return redirect()
        ->route('citas.index')
        ->with(
            'success',
            'Mecánico asignado correctamente.'
        );
}


    /**
     * Eliminar cita.
     */
    public function destroy(Appointment $cita)
    {
        $cita->delete();

        return redirect()
            ->route('citas.index')
            ->with(
                'success',
                'Cita eliminada correctamente.'
            );
    }


    /**
     * Obtener información de un cliente
     * y sus vehículos mediante AJAX.
     */
    public function getClientData(Client $client)
    {
        return response()->json([

            'phone' => $client->phone,

            'vehicles' => $client
                ->vehicles()
                ->get([
                    'id',
                    'brand',
                    'model',
                    'year',
                    'mileage'
                ])

        ]);
    }


    /**
     * Crear cliente mediante AJAX desde Admin.
     */
    public function storeClientAjax(Request $request)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'phone' => [
                'required',
                'string',
                'max:20'
            ],

            'email' => [
                'nullable',
                'email',
                'max:255'
            ],

        ]);


        $client = Client::create([

            'name' => $validated['name'],

            'phone' => $validated['phone'],

            'email' => $validated['email'] ?? null,

        ]);


        return response()->json([

            'success' => true,

            'client' => $client

        ]);
    }


    /**
     * Crear cita desde el formulario público.
     *
     * Este método crea:
     * 1. Cliente
     * 2. Vehículo
     * 3. Cita
     */
    
public function publicStore(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'phone' => ['required', 'string', 'max:20'],

        'brand' => ['required', 'string', 'max:100'],
        'model' => ['required', 'string', 'max:100'],
        'year' => ['required', 'integer'],
        'engine' => ['required', 'string', 'max:100'],
        'color' => ['required', 'string', 'max:100'],
        'plates' => ['nullable', 'string', 'max:50'],
        'mileage' => ['required', 'numeric', 'min:0'],

        'appointment_date' => ['required', 'date', 'after_or_equal:today'],
        'appointment_time' => ['required'],
        'service_type' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string', 'max:1000'],
    ]);

    $appointment = DB::transaction(function () use ($validated) {
        $client = Client::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => null,
            'user_id' => null,
        ]);

        $vehicle = Vehicle::create([
            'client_id' => $client->id,
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'year' => $validated['year'],
            'engine' => $validated['engine'],
            'color' => $validated['color'],
            'plates' => $validated['plates'] ?? null,
            'mileage' => $validated['mileage'],
        ]);

        $appointment = Appointment::create([
            'client_id' => $client->id,
            'vehicle_id' => $vehicle->id,
            'mechanic_id' => null,
            'service_type' => $validated['service_type'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'status' => 'pendiente',
            'notes' => $validated['description'] ?? null,
        ]);

        $appointment->folio =
            'AM-' . now()->format('Y') . '-' .
            str_pad((string) $appointment->id, 6, '0', STR_PAD_LEFT);

        $appointment->save();

        return $appointment;
    });

    // Autorización temporal asociada a la sesión, no solamente al folio.
    $pendingAccounts = $request->session()->get('pending_public_accounts', []);

    $pendingAccounts[$appointment->id] = bin2hex(random_bytes(32));

    $request->session()->put('pending_public_accounts', $pendingAccounts);

    return response()->json([
        'success' => true,
        'folio' => $appointment->folio,
        'name' => $appointment->client->name,
        'date' => $appointment->appointment_date->format('Y-m-d'),
        'time' => $appointment->appointment_time,
        'account_token' => $pendingAccounts[$appointment->id],
        'appointment_id' => $appointment->id,
    ]);
}


public function completePublicAccount(Request $request)
{
    $validated = $request->validate([
        'appointment_id' => ['required', 'integer'],
        'account_token' => ['required', 'string', 'size:64'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $pendingAccounts = $request->session()->get('pending_public_accounts', []);
    $appointmentId = (string) $validated['appointment_id'];
    $storedToken = $pendingAccounts[$appointmentId] ?? null;

    if (
        ! is_string($storedToken) ||
        ! hash_equals($storedToken, $validated['account_token'])
    ) {
        return response()->json([
            'message' => 'La sesión de esta cita expiró o no es válida. Vuelve a realizar el proceso.',
        ], 403);
    }

    $appointment = Appointment::with('client')
        ->find($validated['appointment_id']);

    if (! $appointment || ! $appointment->client) {
        return response()->json([
            'message' => 'No se encontró la cita o su cliente.',
        ], 404);
    }

    if ($appointment->client->user_id !== null) {
        return response()->json([
            'message' => 'Esta cita ya está vinculada a una cuenta.',
        ], 409);
    }

    $user = DB::transaction(function () use ($validated, $appointment) {
        $client = Client::whereKey($appointment->client_id)
            ->lockForUpdate()
            ->firstOrFail();

        if ($client->user_id !== null) {
            abort(409, 'Este cliente ya tiene una cuenta vinculada.');
        }

        $user = User::create([
            'name' => $client->name,
            'email' => $validated['email'],
            'phone' => $client->phone,
            'password' => $validated['password'],
            'rol' => 'cliente',
        ]);

        $client->update([
            'user_id' => $user->id,
            'email' => $user->email,
        ]);

        return $user;
    });

    unset($pendingAccounts[$appointmentId]);
    $request->session()->put('pending_public_accounts', $pendingAccounts);

    Auth::login($user);
    $request->session()->regenerate();

    return response()->json([
        'success' => true,
        'message' => 'Tu cuenta fue creada y vinculada con tu cita.',
        'redirect' => url('/cliente'),
    ]);
}


}