<?php

use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ClientVehicleController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ClientAppointmentController;
use App\Http\Controllers\ClientAuthorizationController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminParameterController;

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

    Route::patch(
    '/admin/citas/{cita}/estado',
    [AppointmentController::class, 'updateStatus']
    )->name('citas.updateStatus');

    Route::patch(
    '/admin/citas/{cita}/mecanico',
    [AppointmentController::class, 'updateMechanic']
    )->name('citas.updateMechanic');

    // GESTIÓN DE USUARIOS
    Route::resource(
        'admin/usuarios',
        AdminUserController::class
    )->names('usuarios');

    Route::patch(
        'admin/usuarios/{usuario}/reset-password',
        [AdminUserController::class, 'resetPassword']
    )->name('usuarios.resetPassword');

    // ACTIVAR Y DESACTIVAR USUARIOS
    Route::patch(
        'admin/usuarios/{usuario}/estado',
        [AdminUserController::class, 'cambiarEstado']
    )->name('usuarios.cambiarEstado');

    // GESTIÓN DE ÓRDENES
    Route::get('/admin/ordenes', [AdminOrderController::class, 'index'])
    ->name('ordenes.index');

    Route::get('/admin/ordenes/{orden}', [AdminOrderController::class, 'show'])
    ->name('ordenes.show');

    // REPORTES DEL ADMINISTRADOR
    Route::get('/admin/reportes', [AdminReportController::class, 'index'])
        ->name('reportes.index');

    Route::get('/admin/reportes/exportar', [AdminReportController::class, 'exportar'])
        ->name('reportes.exportar');

    // PARÁMETROS GENERALES

    Route::get('/admin/parametros', [
        AdminParameterController::class,
        'index'
    ])->name('parametros.index');

    Route::put('/admin/parametros', [
        AdminParameterController::class,
        'update'
    ])->name('parametros.update');

    Route::put('/admin/parametros/citas', [
    AdminParameterController::class, 'updateAppointments'
    ])->name('parametros.citas.update');
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

Route::post('/completar-cuenta-cita', [
    AppointmentController::class,
    'completePublicAccount'
])->name('appointments.complete-account');

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

    Route::get('/cliente/autorizaciones', [
    ClientAuthorizationController::class,
    'index'
])
    ->middleware(['auth', 'role:cliente'])
    ->name('cliente.autorizaciones');

    Route::patch('/cliente/autorizaciones/{cita}/aprobar', [
    ClientAuthorizationController::class,
    'approve'
])
    ->middleware(['auth', 'role:cliente'])
    ->name('cliente.autorizaciones.approve');

Route::patch('/cliente/autorizaciones/{cita}/rechazar', [
    ClientAuthorizationController::class,
    'reject'
])
    ->middleware(['auth', 'role:cliente'])
    ->name('cliente.autorizaciones.reject');

    Route::get('/cliente/citas', [
    ClientAppointmentController::class,
    'index'
])
    ->middleware(['auth', 'role:cliente'])
    ->name('cliente.citas.index');


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
            ->with('vehicle')
            ->orderBy('appointment_date')
            ->get()
        : collect();


    /*
     * Próxima cita.
     */
    $nextAppointment = $appointments
        ->whereNotIn('status', \App\Models\Appointment::FINISHED_STATUSES)
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
            \App\Models\Appointment::FINISHED_STATUSES
        )
        ->first();


    /*
     * Presupuestos que esperan la autorización del cliente
     * (se muestran al inicio, sin tener que entrar al menú).
     */
    $pendingAuthorizationsList = $client
        ? $client->appointments()
            ->with(['vehicle', 'orderItems'])
            ->where('status', 'esperando_aprobacion')
            ->where('authorization_status', 'pendiente')
            ->orderByDesc('diagnosis_submitted_at')
            ->get()
        : collect();


    return view(
        'cliente.dashboard',
        compact(
            'vehicles',
            'nextAppointment',
            'activeOrder',
            'pendingAuthorizationsList'
        )
    );

})
    ->middleware(['auth', 'role:cliente'])
    ->name('cliente.dashboard');


// RASTREAR ÓRDENES DEL CLIENTE
Route::get('/cliente/rastrear-orden', function () {

    $client = auth()->user()->client;

    $orders = $client
        ? $client->appointments()
            ->with('vehicle')
            ->whereNotIn('status', \App\Models\Appointment::FINISHED_STATUSES)
            ->orderByDesc('appointment_date')
            ->get()
        : collect();

    return view('cliente.rastrear-orden', compact('orders'));

})
    ->middleware(['auth', 'role:cliente'])
    ->name('cliente.rastrear-orden');


// HISTORIAL DEL CLIENTE
Route::get('/cliente/historial', function () {

    $client = auth()->user()->client;

    $history = $client
        ? $client->appointments()
            ->with('vehicle')
            ->whereIn('status', \App\Models\Appointment::FINISHED_STATUSES)
            ->orderByDesc('appointment_date')
            ->get()
        : collect();

    return view('cliente.historial', compact('history'));

})
    ->middleware(['auth', 'role:cliente'])
    ->name('cliente.historial');


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
|
| Todo el trabajo de una orden ocurre en su ficha (mecanico.ordenes.ficha).
| Las pantallas antiguas (ordenes/nueva, ordenes/detalle, ordenes/estatus)
| solo redirigen a la ficha o a Mis órdenes; sus POST/PATCH siguen activos.
*/

Route::middleware(['auth', 'role:mecanico'])->group(function () {

    // Mis citas (con filtros ?filtro=activas|hoy|todas)
    Route::get('/mecanico', [\App\Http\Controllers\MecanicoController::class, 'index'])
        ->name('mecanico.dashboard');

    // Ficha única de la orden (Ingreso -> Diagnóstico y presupuesto -> Reparación -> Entrega)
    Route::get('/mecanico/ordenes/{cita}', [\App\Http\Controllers\MechanicOrderController::class, 'show'])
        ->whereNumber('cita')
        ->name('mecanico.ordenes.ficha');

    // Enlaces anteriores: redirigen a la ficha
    Route::get('/mecanico/citas/{cita}', [\App\Http\Controllers\MecanicoController::class, 'show'])
        ->name('mecanico.citas.show');

    // Ingreso del vehículo
    Route::get('/mecanico/ordenes/nueva', [\App\Http\Controllers\MechanicIntakeController::class, 'create'])
        ->name('mecanico.ordenes.create');

    Route::post('/mecanico/ordenes/ingreso', [\App\Http\Controllers\MechanicIntakeController::class, 'store'])
        ->name('mecanico.ordenes.store');

    // Detalle: diagnóstico, servicios, refacciones y solicitud de autorización
    Route::get('/mecanico/ordenes/detalle', [\App\Http\Controllers\MechanicOrderDetailController::class, 'index'])
        ->name('mecanico.ordenes.detalle');

    Route::get('/mecanico/ordenes/{cita}/detalle', [\App\Http\Controllers\MechanicOrderDetailController::class, 'show'])
        ->name('mecanico.ordenes.detalle.show');

    Route::patch('/mecanico/ordenes/{cita}/detalle', [\App\Http\Controllers\MechanicOrderDetailController::class, 'save'])
        ->name('mecanico.ordenes.detalle.save');

    // Cambio de estatus, notas y entrega
    Route::get('/mecanico/ordenes/estatus', [\App\Http\Controllers\MechanicStatusController::class, 'index'])
        ->name('mecanico.ordenes.estatus');

    Route::patch('/mecanico/ordenes/{cita}/estatus', [\App\Http\Controllers\MechanicStatusController::class, 'update'])
        ->name('mecanico.ordenes.estatus.update');
});

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