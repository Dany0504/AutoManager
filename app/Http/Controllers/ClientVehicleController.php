<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientVehicleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $client = $user->client;

        $vehicles = $client
            ? $client->vehicles()->latest()->get()
            : collect();

        return view('cliente.vehiculos', compact('vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:1950|max:2035',
            'engine' => 'required|string|max:100',
            'plates' => 'nullable|string|max:20',
            'mileage' => 'required|integer|min:0',
            'color' => 'required|string|max:30',
        ]);

        $user = Auth::user();
    
        // Si el usuario todavía no tiene registro en clients,
        // lo creamos automáticamente.
        $client = $user->client;

        if (!$client) {
            $client = Client::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]);
        }

        Vehicle::create([
            'client_id' => $client->id,
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'engine' => $request->engine,
            'plates' => $request->plates,
            'mileage' => $request->mileage,
            'color' => $request->color,
        ]);

        return redirect()
            ->route('cliente.vehiculos')
            ->with('success', 'Vehículo agregado correctamente.');
    }
    public function edit(Vehicle $vehicle)
{
    $client = Auth::user()->client;

    // Evita que un cliente edite vehículos de otro cliente
    abort_if(!$client || $vehicle->client_id !== $client->id, 403);

    $vehicles = $client->vehicles()->latest()->get();

    return view('cliente.vehiculos', compact('vehicles', 'vehicle'));
}

public function update(Request $request, Vehicle $vehicle)
{
    $client = Auth::user()->client;

    // Seguridad: solamente puede modificar sus propios vehículos
    abort_if(!$client || $vehicle->client_id !== $client->id, 403);

    $request->validate([
        'brand' => 'required|string|max:50',
        'model' => 'required|string|max:50',
        'year' => 'required|integer|min:1950|max:2035',
        'engine' => 'required|string|max:100',
        'plates' => 'nullable|string|max:20',
        'mileage' => 'required|integer|min:0',
        'color' => 'required|string|max:30',
    ]);

    $vehicle->update([
        'brand' => $request->brand,
        'model' => $request->model,
        'year' => $request->year,
        'engine' => $request->engine,
        'plates' => $request->plates,
        'mileage' => $request->mileage,
        'color' => $request->color,
    ]);

    return redirect()
        ->route('cliente.vehiculos')
        ->with('success', 'Vehículo actualizado correctamente.');
}
}