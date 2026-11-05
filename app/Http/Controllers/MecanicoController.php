<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MecanicoController extends Controller
{
    /**
     * Dashboard principal del mecánico.
     */
    public function index()
    {
        $mechanicId = Auth::id();

        $appointments = Appointment::with([
            'client',
            'vehicle',
        ])
            ->where('mechanic_id', $mechanicId)
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $totalCitas = $appointments->count();

        $pendientes = $appointments
            ->where('status', 'pendiente')
            ->count();

        $enProceso = $appointments
            ->whereIn('status', [
                'diagnostico',
                'esperando_aprobacion',
                'en_proceso',
                'control_calidad',
            ])
            ->count();

        $listas = $appointments
            ->where('status', 'listo')
            ->count();

        return view(
            'mecanico.dashboard',
            compact(
                'appointments',
                'totalCitas',
                'pendientes',
                'enProceso',
                'listas'
            )
        );
    }

    /**
     * Mostrar cita del mecánico.
     *
     * Ya no cambiamos automáticamente
     * el estado al abrir la cita.
     */
    public function show(Appointment $cita)
    {
        abort_unless(
            (int) $cita->mechanic_id === (int) Auth::id(),
            403
        );

        $cita->load([
            'client',
            'vehicle',
        ]);

        return view(
            'mecanico.orden',
            compact('cita')
        );
    }

    /**
     * Compatibilidad con el formulario anterior.
     *
     * La captura de diagnósticos y presupuestos
     * ahora se realiza desde Detalle de orden.
     */
    public function updateDiagnosis(
        Request $request,
        Appointment $cita
    ) {
        abort_unless(
            (int) $cita->mechanic_id === (int) Auth::id(),
            403
        );

        abort_unless(
            $cita->intake_registered_at !== null,
            403,
            'Primero debes registrar el ingreso del vehículo.'
        );

        return redirect()
            ->route(
                'mecanico.ordenes.detalle',
                ['cita' => $cita->id]
            )
            ->with(
                'error',
                'Ahora debes guardar el diagnóstico y los conceptos desde Detalle de orden.'
            );
    }
}