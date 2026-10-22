<?php

namespace App\Http\Controllers;

use App\Models\WorkshopSetting;
use App\Models\AppointmentSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AdminParameterController extends Controller
{
    private function defaultServices(): array
    {
        return [
            ['name' => 'Cambio de aceite', 'duration' => 45, 'capacity' => 3],
            ['name' => 'Frenos', 'duration' => 90, 'capacity' => 2],
            ['name' => 'Alineación y balanceo', 'duration' => 60, 'capacity' => 2],
            ['name' => 'Servicio mayor', 'duration' => 180, 'capacity' => 1],
            ['name' => 'Diagnóstico general', 'duration' => 60, 'capacity' => 2],
        ];
    }

    public function index()
    {
        $settings = WorkshopSetting::first();

        if (!$settings) {
            $settings = new WorkshopSetting([
                'name' => 'AutoManager',
                'rfc' => '',
                'phone' => '',
                'address' => '',
                'email' => '',
                'tax_percentage' => 16,
            ]);
        }

        $appointmentSettings = AppointmentSetting::first();

        if (!$appointmentSettings) {
            $appointmentSettings = new AppointmentSetting([
                'opening_time' => '08:00',
                'closing_time' => '18:00',
                'slot_duration' => 60,
                'break_start' => '14:00',
                'working_days' => [1, 2, 3, 4, 5, 6],
                'services' => $this->defaultServices(),
                'blocked_dates' => [],
            ]);
        }

        return view('admin.parametros.index', compact(
            'settings',
            'appointmentSettings'
        ));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'rfc' => [
                'nullable',
                'string',
                'regex:/^[A-Za-zÑñ&]{3,4}[0-9]{6}[A-Za-z0-9]{3}$/',
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:1000'],
            'email' => ['nullable', 'email', 'max:255'],
            'tax_percentage' => ['required', 'numeric', 'between:0,100'],
        ]);

        $settings = WorkshopSetting::first() ?? new WorkshopSetting();

        $settings->fill([
            'name' => $validated['name'],
            'rfc' => strtoupper($validated['rfc'] ?? ''),
            'phone' => $validated['phone'] ?? '',
            'address' => $validated['address'] ?? '',
            'email' => $validated['email'] ?? '',
            'tax_percentage' => $validated['tax_percentage'],
        ]);

        $settings->save();

        return redirect()
            ->route('parametros.index')
            ->with('success', 'Los parámetros generales se guardaron correctamente.');
    }

    public function updateAppointments(Request $request)
    {
        $validated = $request->validate([
            'opening_time' => ['required', 'date_format:H:i'],
            'closing_time' => ['required', 'date_format:H:i'],
            'slot_duration' => ['required', 'integer', 'min:5', 'max:480'],
            'break_start' => ['nullable', 'date_format:H:i'],
            'working_days' => ['required', 'array', 'min:1'],
            'working_days.*' => ['required', 'integer', 'between:0,6'],
            'services' => ['required', 'array', 'size:5'],
            'services.*.name' => ['required', 'string', 'max:100'],
            'services.*.duration' => ['required', 'integer', 'min:5', 'max:1440'],
            'services.*.capacity' => ['required', 'integer', 'min:1', 'max:100'],
            'blocked_dates' => ['nullable', 'array'],
            'blocked_dates.*' => ['required', 'date_format:Y-m-d', 'distinct'],
        ]);

        if ($validated['closing_time'] <= $validated['opening_time']) {
            throw ValidationException::withMessages([
                'closing_time' => 'El cierre debe ser posterior a la apertura.',
            ]);
        }

        if (
            !empty($validated['break_start']) &&
            (
                $validated['break_start'] <= $validated['opening_time'] ||
                $validated['break_start'] >= $validated['closing_time']
            )
        ) {
            throw ValidationException::withMessages([
                'break_start' => 'El descanso debe estar dentro del horario de atención.',
            ]);
        }

        $allowedServices = array_column($this->defaultServices(), 'name');
        $receivedServices = array_column($validated['services'], 'name');

        if (
            count(array_unique($receivedServices)) !== count($allowedServices) ||
            array_diff($receivedServices, $allowedServices) ||
            array_diff($allowedServices, $receivedServices)
        ) {
            throw ValidationException::withMessages([
                'services' => 'La lista de servicios no es válida.',
            ]);
        }

        $appointmentSettings = AppointmentSetting::first()
            ?? new AppointmentSetting();

        $appointmentSettings->fill([
            'opening_time' => $validated['opening_time'],
            'closing_time' => $validated['closing_time'],
            'slot_duration' => $validated['slot_duration'],
            'break_start' => $validated['break_start'] ?? null,
            'working_days' => array_values(
                array_unique($validated['working_days'])
            ),
            'services' => $validated['services'],
            'blocked_dates' => array_values(
                $validated['blocked_dates'] ?? []
            ),
        ]);

        $appointmentSettings->save();

        return redirect()
            ->route('parametros.index', ['#' => 'configuracion-citas'])
            ->with('success', 'La configuración de citas se guardó correctamente.');
    }
}
