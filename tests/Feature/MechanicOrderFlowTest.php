<?php

use App\Models\Appointment;
use App\Models\Client;
use App\Models\MechanicStatusLog;
use App\Models\User;
use App\Models\Vehicle;

/*
 * Recorre la ficha única de orden del mecánico:
 * Ingreso → Diagnóstico y presupuesto → autorización del cliente → Reparación → Entrega.
 */

function crearOrden(): array
{
    $mecanico = User::factory()->create();
    $mecanico->forceFill(['rol' => 'mecanico'])->save();

    $usuarioCliente = User::factory()->create(['name' => 'Ana Cliente']);
    $usuarioCliente->forceFill(['rol' => 'cliente'])->save();

    $cliente = Client::create([
        'user_id' => $usuarioCliente->id,
        'name' => 'Ana Cliente',
        'phone' => '6621234567',
        'email' => $usuarioCliente->email,
    ]);

    $vehiculo = Vehicle::create([
        'client_id' => $cliente->id,
        'brand' => 'Mazda',
        'model' => '3',
        'year' => 2018,
        'engine' => '2.5',
        'color' => 'Rojo',
        'plates' => 'ABC-123',
        'mileage' => 50000,
    ]);

    $cita = Appointment::forceCreate([
        'folio' => 'AM-2026-000123',
        'client_id' => $cliente->id,
        'vehicle_id' => $vehiculo->id,
        'mechanic_id' => $mecanico->id,
        'service_type' => 'Frenos',
        'appointment_date' => now()->toDateString(),
        'appointment_time' => '10:00',
        'status' => 'pendiente',
        'notes' => 'Rechinan los frenos',
    ]);

    return [$mecanico, $usuarioCliente, $cita];
}

test('el mecánico completa una orden desde su ficha única', function () {
    [$mecanico, $usuarioCliente, $cita] = crearOrden();
    $ficha = route('mecanico.ordenes.ficha', $cita);

    // Mis órdenes lleva a la ficha con la acción correcta
    $this->actingAs($mecanico)->get(route('mecanico.dashboard'))
        ->assertOk()
        ->assertSee('Mis órdenes')
        ->assertSee($ficha, false)
        ->assertSee('Registrar ingreso');

    // Paso 1: formulario de ingreso, con la falla del cliente precargada
    $this->get($ficha)
        ->assertOk()
        ->assertSee('Estado del vehículo al llegar')
        ->assertSee('Rechinan los frenos');

    $this->from($ficha)->post(route('mecanico.ordenes.store'), [
        'appointment_id' => $cita->id,
        'intake_mileage' => 50210,
        'intake_fuel_level' => '1/2',
        'intake_customer_description' => 'Rechinan los frenos',
    ])->assertRedirect($ficha);

    expect($cita->fresh()->status)->toBe('diagnostico');

    // Paso 2: diagnóstico y presupuesto
    $this->get($ficha)
        ->assertOk()
        ->assertSee('Diagnóstico del vehículo')
        ->assertSee('Solicitar autorización al cliente');

    $this->from($ficha)->patch(route('mecanico.ordenes.detalle.save', $cita), [
        'action' => 'submit',
        'diagnosis' => 'Balatas delanteras gastadas',
        'items' => [
            ['type' => 'refaccion', 'name' => 'Balatas', 'quantity' => 1, 'unit_price' => 850],
            ['type' => 'servicio', 'name' => 'Mano de obra', 'quantity' => 1, 'unit_price' => 400],
        ],
    ])->assertRedirect($ficha);

    expect($cita->fresh()->status)->toBe('esperando_aprobacion');

    $this->get($ficha)->assertSee('Esperando la respuesta del cliente');

    // El cliente autoriza → la orden pasa sola a Reparación
    $this->actingAs($usuarioCliente)
        ->patch(route('cliente.autorizaciones.approve', $cita))
        ->assertRedirect();

    expect($cita->fresh()->status)->toBe('en_proceso');

    // Paso 3: reparación
    $this->actingAs($mecanico)->get($ficha)
        ->assertOk()
        ->assertSee('Pasar a control de calidad');

    $this->from($ficha)->patch(route('mecanico.ordenes.estatus.update', $cita), [
        'action' => 'advance',
        'note' => 'Se cambiaron balatas',
    ])->assertRedirect($ficha);

    $this->get($ficha)->assertSee('Marcar como listo para entrega');

    $this->from($ficha)->patch(route('mecanico.ordenes.estatus.update', $cita), [
        'action' => 'advance',
    ])->assertRedirect($ficha);

    // Paso 4: entrega
    $this->get($ficha)
        ->assertOk()
        ->assertSee('Entregar el vehículo')
        ->assertSee('$1,250.00');

    $this->from($ficha)->patch(route('mecanico.ordenes.estatus.update', $cita), [
        'action' => 'deliver',
    ])->assertRedirect($ficha);

    expect($cita->fresh()->status)->toBe('entregado');

    $this->get($ficha)->assertSee('Orden cerrada');

    // Los pasos anteriores se pueden consultar en solo lectura
    $this->get($ficha . '?paso=2')
        ->assertOk()
        ->assertSee('Balatas delanteras gastadas')
        ->assertSee('Estás viendo un paso anterior')
        ->assertDontSee('Solicitar autorización al cliente');

    // Cada movimiento quedó en el historial
    expect(MechanicStatusLog::where('appointment_id', $cita->id)->count())->toBe(6);

    // Una orden entregada sale de "Activas" pero aparece en "Todas"
    $this->get(route('mecanico.dashboard'))->assertDontSee('AM-2026-000123');
    $this->get(route('mecanico.dashboard', ['filtro' => 'todas']))->assertSee('AM-2026-000123');
});

test('no se puede saltar a un paso futuro', function () {
    [$mecanico, , $cita] = crearOrden();

    $this->actingAs($mecanico)
        ->get(route('mecanico.ordenes.ficha', ['cita' => $cita, 'paso' => 3]))
        ->assertOk()
        ->assertSee('Estado del vehículo al llegar')
        ->assertDontSee('Pasar a control de calidad');
});

test('otro mecánico no puede abrir la ficha', function () {
    [, , $cita] = crearOrden();

    $otro = User::factory()->create();
    $otro->forceFill(['rol' => 'mecanico'])->save();

    $this->actingAs($otro)
        ->get(route('mecanico.ordenes.ficha', $cita))
        ->assertForbidden();
});

test('las pantallas anteriores redirigen a la ficha o a Mis órdenes', function () {
    [$mecanico, , $cita] = crearOrden();
    $ficha = route('mecanico.ordenes.ficha', $cita);

    $this->actingAs($mecanico);

    $this->get(route('mecanico.citas.show', $cita))->assertRedirect($ficha);
    $this->get(route('mecanico.ordenes.create', ['cita' => $cita->id]))->assertRedirect($ficha);
    $this->get(route('mecanico.ordenes.detalle', ['cita' => $cita->id]))->assertRedirect($ficha);
    $this->get(route('mecanico.ordenes.estatus', ['cita' => $cita->id]))->assertRedirect($ficha);
    $this->get(route('mecanico.ordenes.detalle'))->assertRedirect(route('mecanico.dashboard'));
});
