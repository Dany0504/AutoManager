<?php
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

Route::middleware(['auth','role:administrador'])->group(function () {

    Route::resource('admin/citas', AppointmentController::class);

    Route::resource('admin/vehiculos', VehicleController::class)
    ->names('vehiculos');

    Route::get('/admin/clientes/{client}/vehiculos',
    [AppointmentController::class, 'getClientData'])
    ->name('clientes.vehiculos');

    Route::post('/admin/clientes/ajax',
    [AppointmentController::class,'storeClientAjax'])
    ->name('clientes.ajax.store');

    Route::post('/admin/vehiculos/ajax',
    [VehicleController::class,'storeAjax'])
    ->name('vehiculos.ajax.store');



});

    Route::post('/agendar-cita',
    [AppointmentController::class, 'publicStore']);

    Route::get('/catalog/marcas/{year}',
    [VehicleController::class,'getBrands']);

    Route::get('/catalog/modelos/{year}/{brand}',
    [VehicleController::class,'getModels']);

    Route::get('/catalog/motores/{year}/{brand}/{model}',
    [VehicleController::class,'getEngines']);

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if($user->rol === 'cliente') {
        return redirect('/cliente');
    }
    if($user->rol === 'mecanico') {
        return redirect('/mecanico');
    }
    if($user->rol === 'administrador') {
        return redirect('/admin');
    }

    abort(403, 'Rol de usuario no válido.');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/cliente', function () {
    return view('cliente.dashboard');
})->middleware(['auth', 'role:cliente']);

Route::get('/mecanico', function () {
    return view('mecanico.dashboard');
})->middleware(['auth', 'role:mecanico']);

Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'role:administrador']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
