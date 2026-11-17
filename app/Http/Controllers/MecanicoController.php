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
    public function index(Request $request)
    {
        $mechanicId = Auth::id();

        // activas (por defecto) | hoy | todas
        $filtro = in_array($request->query('filtro'), ['activas', 'hoy', 'todas'], true)
            ? $request->query('filtro')
            : 'activas';

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

        // Las estadísticas usan todas las citas; la tabla, solo las del filtro.
        $activas = $appointments->reject(
            fn ($cita) => in_array($cita->status, Appointment::FINISHED_STATUSES, true)
        );

        $conteoFiltros = [
            'activas' => $activas->count(),
            'hoy' => $activas->filter(fn ($cita) => $cita->appointment_date?->isToday())->count(),
            'todas' => $appointments->count(),
        ];

        $appointments = match ($filtro) {
            'hoy' => $activas->filter(fn ($cita) => $cita->appointment_date?->isToday())->values(),
            'todas' => $appointments,
            default => $activas->values(),
        };

        return view(
            'mecanico.dashboard',
            compact(
                'appointments',
                'totalCitas',
                'pendientes',
                'enProceso',
                'listas',
                'filtro',
                'conteoFiltros'
            )
        );
    }

    /**
     * Enlace anterior a una cita: ahora abre su ficha única.
     */
    public function show(Appointment $cita)
    {
        return redirect()->route('mecanico.ordenes.ficha', $cita);
    }
}