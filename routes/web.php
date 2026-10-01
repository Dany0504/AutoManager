<?php

use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ClientVehicleController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ClientAppointmentController;


/*
|--------------------------------------------------------------------------
| ADMINISTRADOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:administrador'])->group(function () {

    Route::resource(
        'admin/citas',
        AppointmentController::class
    );

    Route::resource(
        'admin/vehiculos',
        VehicleController::class
    )->names('vehiculos');


    Route::get(
        '/admin/clientes/{client}/vehiculos',
        [AppointmentController::class, 'getClientData']
    )->name('clientes.vehiculos');


    Route::post(
        '/admin/clientes/ajax',
        [AppointmentController::class, 'storeClientAjax']
    )->name('clientes.ajax.store');


    Route::post(
        '/admin/vehiculos/ajax',
        [VehicleController::class, 'storeAjax']
    )->name('vehiculos.ajax.store');

});


/*
|--------------------------------------------------------------------------
| AGENDAR CITA PÚBLICA
|--------------------------------------------------------------------------
*/

Route::post(
    '/agendar-cita',
    [AppointmentController::class, 'publicStore']
);


/*
|--------------------------------------------------------------------------
| CLIENTE - AGENDAR CITA
|--------------------------------------------------------------------------
*/

Route::get(
    '/cliente/agendar-cita',
    [ClientAppointmentController::class, 'create']
)
    ->middleware(['auth', 'role:cliente'])
    ->name('cliente.citas.create');


Route::post(
    '/cliente/agendar-cita',
    [ClientAppointmentController::class, 'store']
)
    ->middleware(['auth', 'role:cliente'])
    ->name('cliente.citas.store');


/*
|--------------------------------------------------------------------------
| CATÁLOGO DE VEHÍCULOS
|--------------------------------------------------------------------------
*/

Route::get(
    '/catalog/marcas/{year}',
    [VehicleController::class, 'getBrands']
);


Route::get(
    '/catalog/modelos/{year}/{brand}',
    [VehicleController::class, 'getModels']
);


Route::get(
    '/catalog/motores/{year}/{brand}/{model}',
    [VehicleController::class, 'getEngines']
);


/*
|--------------------------------------------------------------------------
| RASTREAR ORDEN
|--------------------------------------------------------------------------
*/

Route::get(
    '/rastrear',
    [TrackingController::class, 'index']
)->name('tracking.index');


Route::post(
    '/rastrear',
    [TrackingController::class, 'track']
)->name('tracking.search');


/*
|--------------------------------------------------------------------------
| PÁGINA PRINCIPAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return view('home');

});


/*
|--------------------------------------------------------------------------
| DASHBOARD GENERAL
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $user = auth()->user();

    if ($user->rol === 'cliente') {
        return redirect('/cliente');
    }

    if ($user->rol === 'mecanico') {
        return redirect('/mecanico');
    }

    if ($user->rol === 'administrador') {
        return redirect('/admin');
    }

    abort(403, 'Rol de usuario no válido.');

})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| CLIENTE - DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/cliente', function () {

    $user = auth()->user();

    $client = $user->client;


    /*
     * Vehículos del cliente.
     */
    $vehicles = $client
        ? $client->vehicles()
            ->latest()
            ->get()
        : collect();


    /*
     * Citas del cliente.
     */
    $appointments = $client
        ? $client->appointments()
            ->orderBy('appointment_date')
            ->get()
        : collect();


    /*
     * Próxima cita.
     */
    $nextAppointment = $appointments
        ->where(
            'appointment_date',
            '>=',
            now()->toDateString()
        )
        ->first();


    /*
     * Orden activa.
     */
    $activeOrder = $appointments
        ->whereNotIn(
            'status',
            ['completado', 'cancelado']
        )
        ->first();


    return view(
        'cliente.dashboard',
        compact(
            'vehicles',
            'nextAppointment',
            'activeOrder'
        )
    );

})
    ->middleware(['auth', 'role:cliente'])
    ->name('cliente.dashboard');


/*
|--------------------------------------------------------------------------
| CLIENTE - VEHÍCULOS
|--------------------------------------------------------------------------
*/

Route::get(
    '/cliente/vehiculos',
    [ClientVehicleController::class, 'index']
)
    ->middleware(['auth', 'role:cliente'])
    ->name('cliente.vehiculos');


Route::post(
    '/cliente/vehiculos',
    [ClientVehicleController::class, 'store']
)
    ->middleware(['auth', 'role:cliente'])
    ->name('cliente.vehiculos.store');


Route::get(
    '/cliente/vehiculos/{vehicle}/editar',
    [ClientVehicleController::class, 'edit']
)
    ->middleware(['auth', 'role:cliente'])
    ->name('cliente.vehiculos.edit');


Route::put(
    '/cliente/vehiculos/{vehicle}',
    [ClientVehicleController::class, 'update']
)
    ->middleware(['auth', 'role:cliente'])
    ->name('cliente.vehiculos.update');


/*
|--------------------------------------------------------------------------
| MECÁNICO
|--------------------------------------------------------------------------
*/

Route::get('/mecanico', function () {

    return view('mecanico.dashboard');

})
    ->middleware(['auth', 'role:mecanico']);


/*
|--------------------------------------------------------------------------
| ADMIN - DASHBOARD
|--------------------------------------------------------------------------
|
| Esta es la modificación que vino del compañero.
| La conservamos.
|
*/

Route::get(
    '/admin',
    [AdminDashboardController::class, 'index']
)
    ->middleware(['auth', 'role:administrador']);


/*
|--------------------------------------------------------------------------
| PERFIL
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get(
        '/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');


    Route::patch(
        '/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');


    Route::delete(
        '/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';