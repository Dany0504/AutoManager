<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\User;



class AppointmentController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $buscar = $request->buscar;

    $appointments = Appointment::with(['client','vehicle','mechanic'])
        ->when($buscar, function($query) use ($buscar){

            $query->where('folio','like',"%{$buscar}%")
                ->orWhereHas('client', function($q) use ($buscar){
                        $q->where('name','like',"%{$buscar}%");
                })
                ->orWhereHas('vehicle', function($q) use ($buscar){
                        $q->where('brand','like',"%{$buscar}%")
                    ->orWhere('model','like',"%{$buscar}%");
                });

        })
        ->latest()
        ->get();

    return view('admin.citas.index', compact('appointments','buscar'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $clients = Client::orderBy('name')->get();

    return view('admin.citas.create', compact('clients'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([

        'client_id' => 'required',

        'vehicle_id' => 'required',

        'service_type' => 'required',

        'appointment_date' => 'required',

        'appointment_time' => 'required'

    ]);

    Appointment::create([

        'client_id' => $request->client_id,

        'vehicle_id' => $request->vehicle_id,

        'mechanic_id' => null,

        'service_type' => $request->service_type,

        'appointment_date' => $request->appointment_date,

        'appointment_time' => $request->appointment_time,

        'notes' => $request->notes,

        'status' => 'pendiente'

    ]);

    return redirect()->route('citas.index')
        ->with('success','Cita creada correctamente');
}

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $cita)
{
    $cita->delete();

    return redirect()->route('citas.index')
        ->with('success', 'Cita eliminada correctamente.');
}

public function getClientData(Client $client)
{
    return response()->json([
        'phone' => $client->phone,
        'vehicles' => $client->vehicles()->get([
            'id',
            'brand',
            'model',
            'year'
        ])
    ]);
}

public function storeClientAjax(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'nullable|email|max:255'
    ]);

    $client = Client::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email
    ]);

    return response()->json([
        'success' => true,
        'client' => $client
    ]);
}

public function publicStore(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'nullable|email',

        'brand' => 'required|string',
        'model' => 'required|string',
        'year' => 'required|integer',
        'engine' => 'required|string',
        'color' => 'required|string',
        'plates' => 'nullable|string',
        'mileage' => 'required|numeric',

        'appointment_date' => 'required|date',
        'appointment_time' => 'required',
        'service_type' => 'required|string',
        'description' => 'nullable|string'
    ]);

    // Crear cliente
    $client = Client::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email
    ]);

    // Crear vehículo
    $vehicle = Vehicle::create([
        'client_id' => $client->id,
        'brand' => $request->brand,
        'model' => $request->model,
        'year' => $request->year,
        'engine' => $request->engine,
        'color' => $request->color,
        'plates' => $request->plates,
        'mileage' => $request->mileage
    ]);

    // Crear cita
    $appointment = Appointment::create([
        'client_id' => $client->id,
        'vehicle_id' => $vehicle->id,
        'mechanic_id' => null,

        'service_type' => $request->service_type,
        'appointment_date' => $request->appointment_date,
        'appointment_time' => $request->appointment_time,

        
        'status' => 'pendiente',

        'notes' => $request->description
    ]);

    // Generar folio
    $appointment->folio = 'AM-' . date('Y') . '-' . str_pad($appointment->id, 6, '0', STR_PAD_LEFT);
    $appointment->save();

    return response()->json([
        'success' => true,
        'folio' => $appointment->folio,
        'name' => $client->name,
        'date' => $appointment->appointment_date,
        'time' => $appointment->appointment_time
    ]);
}
}
