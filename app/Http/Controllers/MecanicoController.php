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
            'vehicle'
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
                'control_calidad'
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
     * Mostrar detalle de una orden.
     */
    public function show(Appointment $cita)
    {
        abort_if(
            $cita->mechanic_id !== Auth::id(),
            403
        );

        $cita->load([
            'client',
            'vehicle'
        ]);

        /*
         * Al abrir por primera vez una orden pendiente,
         * pasa a diagnóstico.
         */
        if ($cita->status === 'pendiente') {
            $cita->update([
                'status' => 'diagnostico'
            ]);
        }

        return view(
            'mecanico.orden',
            compact('cita')
        );
    }


    /**
     * Guardar o enviar diagnóstico.
     */
    public function updateDiagnosis(
        Request $request,
        Appointment $cita
    ) {
        abort_if(
            $cita->mechanic_id !== Auth::id(),
            403
        );

        $validated = $request->validate([
            'diagnosis' => [
                'required',
                'string',
                'max:5000'
            ],

            'estimated_cost' => [
                'required',
                'numeric',
                'min:0'
            ],

            'action' => [
                'required',
                'in:draft,submit'
            ],
        ]);

        /*
         * Guardar borrador.
         */
        if ($validated['action'] === 'draft') {

            $cita->update([
                'diagnosis' => $validated['diagnosis'],
                'estimated_cost' => $validated['estimated_cost'],
                'status' => 'diagnostico',
                'authorization_status' => 'pendiente',
            ]);

            return redirect()
                ->route('mecanico.citas.show', $cita)
                ->with(
                    'success',
                    'Diagnóstico guardado como borrador.'
                );
        }

        /*
         * Enviar diagnóstico.
         */
        $cita->update([
            'diagnosis' => $validated['diagnosis'],
            'estimated_cost' => $validated['estimated_cost'],
            'status' => 'esperando_aprobacion',
            'authorization_status' => 'pendiente',
            'diagnosis_submitted_at' => now(),
        ]);

        return redirect()
            ->route('mecanico.citas.show', $cita)
            ->with(
                'success',
                'Diagnóstico enviado correctamente.'
            );
    }
}