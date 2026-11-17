<?php

use App\Models\Appointment;
use App\Models\Client;
use App\Models\User;
use App\Models\Vehicle;

/*
 * Portal del cliente: historial, autorizaciones en el inicio
 * y aviso de pendientes en el menú.
 */

function clienteConCita(string $status, array $extra = []): array
{
    $mecanico = User::factory()->create();
    $mecanico->forceFill(['rol' => 'mecanico'])->save();

    $usuario = User::factory()->create(['name' => 'Ana Cliente']);
    $usuario->forceFill(['rol' => 'cliente'])->save();

    $cliente = Client::create([
        'user_id' => $usuario->id,
        'name' => 'Ana Cliente',
        'phone' => '6621234567',
        'email' => $usuario->email,
    ]);

    $vehiculo = Vehicle::create([
        'client_id' => $cliente->id,
        'brand' => 'Mazda',
        'model' => '3',
        'year' => 2018,
        'engine' => '2.5',
        'color' => 'Rojo',
        'mileage' => 50000,
    ]);

    $cita = Appointment::forceCreate(array_merge([
        'folio' => 'AM-2026-000777',
        'client_id' => $cliente->id,
        'vehicle_id' => $vehiculo->id,
        'mechanic_id' => $mecanico->id,
        'service_type' => 'Frenos',
        'appointment_date' => now()->toDateString(),
        'appointment_time' => '10:00',
        'status' => $status,
    ], $extra));

    return [$usuario, $cita];
}

test('una orden entregada aparece en el historial y ya no en rastrear', function () {
    [$usuario] = clienteConCita('entregado', [
        'diagnosis' => 'Balatas delanteras gastadas',
        'estimated_cost' => 1250,
    ]);

    $this->actingAs($usuario);

    $this->get(route('cliente.historial'))
        ->assertOk()
        ->assertSee('AM-2026-000777')
        ->assertSee('Entregado')
        ->assertSee('Balatas delanteras gastadas')
        ->assertSee('$1,250.00');

    $this->get(route('cliente.rastrear-orden'))
        ->assertOk()
        ->assertDontSee('AM-2026-000777');
});

test('el inicio muestra los presupuestos por autorizar y el menú la bolita', function () {
    [$usuario, $cita] = clienteConCita('esperando_aprobacion', [
        'authorization_status' => 'pendiente',
        'diagnosis' => 'Cambiar balatas y rectificar discos',
        'estimated_cost' => 2150,
        'diagnosis_submitted_at' => now(),
    ]);

    $this->actingAs($usuario);

    $this->get(route('cliente.dashboard'))
        ->assertOk()
        ->assertSee('Tienes un presupuesto por autorizar')
        ->assertSee('Cambiar balatas y rectificar discos')
        ->assertSee('$2,150.00 MXN')
        ->assertSee(route('cliente.autorizaciones.approve', $cita), false)
        ->assertSee('class="menu-aviso"', false);

    // La bolita aparece en cualquier pantalla del cliente
    $this->get(route('cliente.historial'))->assertSee('class="menu-aviso"', false);

    // Autorizar desde el inicio regresa al inicio y quita el aviso
    $this->from(route('cliente.dashboard'))
        ->patch(route('cliente.autorizaciones.approve', $cita))
        ->assertRedirect(route('cliente.dashboard'));

    expect($cita->fresh()->status)->toBe('en_proceso');

    $this->get(route('cliente.dashboard'))
        ->assertOk()
        ->assertSee('Reparación autorizada correctamente.')
        ->assertDontSee('Tienes un presupuesto por autorizar')
        ->assertDontSee('class="menu-aviso"', false)
        ->assertSee('Estado: <strong>En proceso</strong>', false);
});

test('sin pendientes no aparece la bolita', function () {
    [$usuario] = clienteConCita('pendiente');

    $this->actingAs($usuario)
        ->get(route('cliente.dashboard'))
        ->assertOk()
        ->assertDontSee('class="menu-aviso"', false)
        ->assertDontSee('Tienes un presupuesto por autorizar');
});

test('todas las pantallas del cliente usan el menú compartido con botón para celular', function () {
    [$usuario] = clienteConCita('pendiente');

    $this->actingAs($usuario);

    foreach ([
        'cliente.dashboard',
        'cliente.vehiculos',
        'cliente.citas.create',
        'cliente.citas.index',
        'cliente.rastrear-orden',
        'cliente.historial',
        'cliente.autorizaciones',
    ] as $ruta) {
        $this->get(route($ruta))
            ->assertOk()
            ->assertSee("toggle.className = 'cliente-menu-toggle'", false);
    }
});

test('el menú del mecánico tiene botón para celular', function () {
    $mecanico = User::factory()->create();
    $mecanico->forceFill(['rol' => 'mecanico'])->save();

    $this->actingAs($mecanico)
        ->get(route('mecanico.dashboard'))
        ->assertOk()
        ->assertSee('id="mechanicMenuToggle"', false)
        ->assertSee('aria-controls="mechanicSidebarPanel"', false);
});
