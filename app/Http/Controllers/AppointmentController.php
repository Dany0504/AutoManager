<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Vehicle;
use Illuminate\Http\Request;

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

        return view(
            'admin.citas.index',
            compact('appointments', 'buscar')
        );
    }


    /**
     * Mostrar formulario para crear cita desde Admin.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();

        return view(
            'admin.citas.create',
            compact('clients')
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

        ]);


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

            'mechanic_id' => null,

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

        $cita->load([
            'client',
            'vehicle',
            'mechanic'
        ]);

        return view(
            'admin.citas.edit',
            compact('cita', 'clients')
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

        ]);


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

            /*
             * CLIENTE
             */
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


            /*
             * VEHÍCULO
             */
            'brand' => [
                'required',
                'string',
                'max:100'
            ],

            'model' => [
                'required',
                'string',
                'max:100'
            ],

            'year' => [
                'required',
                'integer'
            ],

            'engine' => [
                'required',
                'string',
                'max:100'
            ],

            'color' => [
                'required',
                'string',
                'max:100'
            ],

            'plates' => [
                'nullable',
                'string',
                'max:50'
            ],

            'mileage' => [
                'required',
                'numeric',
                'min:0'
            ],


            /*
             * CITA
             */
            'appointment_date' => [
                'required',
                'date'
            ],

            'appointment_time' => [
                'required'
            ],

            'service_type' => [
                'required',
                'string',
                'max:255'
            ],


            /*
             * OBSERVACIONES / FALLA
             *
             * Mantenemos "description" porque el
             * formulario público actual ya puede
             * estar enviando ese nombre.
             */
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],

        ]);


        /*
         * ==============================
         * CREAR CLIENTE
         * ==============================
         */

        $client = Client::create([

            'name' => $validated['name'],

            'phone' => $validated['phone'],

            'email' => $validated['email'] ?? null,

        ]);


        /*
         * ==============================
         * CREAR VEHÍCULO
         * ==============================
         */

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


        /*
         * ==============================
         * CREAR CITA
         * ==============================
         */

        $appointment = Appointment::create([

            'client_id' => $client->id,

            'vehicle_id' => $vehicle->id,

            'mechanic_id' => null,

            'service_type' => $validated['service_type'],

            'appointment_date' =>
                $validated['appointment_date'],

            'appointment_time' =>
                $validated['appointment_time'],

            'status' => 'pendiente',

            /*
             * "description" del formulario
             * se guarda en la columna "notes"
             * de appointments.
             */
            'notes' => $validated['description'] ?? null,

        ]);


        /*
         * ==============================
         * GENERAR FOLIO
         * ==============================
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


        /*
         * ==============================
         * RESPUESTA
         * ==============================
         */

        return response()->json([

            'success' => true,

            'folio' => $appointment->folio,

            'name' => $client->name,

            'date' => $appointment->appointment_date,

            'time' => $appointment->appointment_time,

        ]);
    }
}