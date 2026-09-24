<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\VehicleCatalog;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $vehicles = Vehicle::with('client')->get();

    return view('admin.vehiculos.index', compact('vehicles'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $clients = Client::orderBy('name')->get();

    return view('admin.vehiculos.create', compact('clients'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'client_id' => 'required',
        'brand' => 'required',
        'model' => 'required',
        'year' => 'required',
        'color' => 'required',
        'mileage' => 'required'
    ]);

    Vehicle::create($request->all());

    return redirect()->route('vehiculos.index')
        ->with('success','Vehículo registrado correctamente');
}

    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }

    public function storeAjax(Request $request)
{
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'brand' => 'required|string|max:50',
        'model' => 'required|string|max:50',
        'year' => 'required|integer|min:1950|max:2035',
        'color' => 'required|string|max:30',
        'plates' => 'nullable|string|max:20',
        'vin' => 'nullable|string|max:30',
        'mileage' => 'required|integer|min:0'
    ]);

    $vehicle = Vehicle::create($request->all());

    return response()->json([
        'success' => true,
        'vehicle' => $vehicle
    ]);
}

public function getBrands($year)
{
    return VehicleCatalog::where('year',$year)
        ->select('brand')
        ->distinct()
        ->orderBy('brand')
        ->pluck('brand');
}

public function getModels($year,$brand)
{
    return VehicleCatalog::where('year',$year)
        ->where('brand',$brand)
        ->select('model')
        ->distinct()
        ->orderBy('model')
        ->pluck('model');
}

public function getEngines($year,$brand,$model)
{
    return VehicleCatalog::where('year',$year)
        ->where('brand',$brand)
        ->where('model',$model)
        ->select('engine')
        ->distinct()
        ->orderBy('engine')
        ->pluck('engine');
}
}
