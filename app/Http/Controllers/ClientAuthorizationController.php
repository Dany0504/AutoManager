<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MechanicStatusLog;
use Illuminate\Support\Facades\Auth;

class ClientAuthorizationController extends Controller
{
    /**
     * Mostrar diagnósticos pendientes de autorización.
     */
    public function index()
    {
        $user = Auth::user();

        $client = $user->client;

        if (!$client) {
            abort(403, 'No se encontró un perfil de cliente.');
        }

        $appointments = Appointment::with([
            'vehicle',
            'mechanic'
        ])
            ->where('client_id', $client->id)
            ->where('status', 'esperando_aprobacion')
            ->where('authorization_status', 'pendiente')
            ->orderByDesc('diagnosis_submitted_at')
            ->get();

        return view(
            'cliente.autorizaciones',
            compact('appointments')
        );
    }


    /**
     * Aprobar reparación.
     */
    public function approve(Appointment $cita)
    {
        $client = Auth::user()->client;

        abort_if(
            !$client || $cita->client_id !== $client->id,
            403
        );

        abort_if(
            $cita->authorization_status !== 'pendiente' ||
            $cita->status !== 'esperando_aprobacion',
            403
        );

        $cita->update([
            'authorization_status' => 'aprobado',
            'status' => 'en_proceso',
            'authorized_at' => now(),
        ]);

        // Queda en el historial que ve el mecánico.
        MechanicStatusLog::create([
            'appointment_id' => $cita->id,
            'mechanic_id' => Auth::id(),
            'previous_status' => 'esperando_aprobacion',
            'new_status' => 'en_proceso',
            'note' => 'El cliente autorizó el presupuesto.',
        ]);

        // Regresa a la pantalla donde se tomó la decisión (inicio o Autorizaciones).
        return redirect()
            ->back(fallback: route('cliente.autorizaciones'))
            ->with(
                'success',
                'Reparación autorizada correctamente.'
            );
    }


    /**
     * Rechazar reparación.
     */
    public function reject(Appointment $cita)
    {
        $client = Auth::user()->client;

        abort_if(
            !$client || $cita->client_id !== $client->id,
            403
        );

        abort_if(
            $cita->authorization_status !== 'pendiente' ||
            $cita->status !== 'esperando_aprobacion',
            403
        );

        $cita->update([
            'authorization_status' => 'rechazado',
            'status' => 'diagnostico',
            'authorized_at' => null,
        ]);

        // Queda en el historial que ve el mecánico.
        MechanicStatusLog::create([
            'appointment_id' => $cita->id,
            'mechanic_id' => Auth::id(),
            'previous_status' => 'esperando_aprobacion',
            'new_status' => 'diagnostico',
            'note' => 'El cliente rechazó el presupuesto. Revisa el diagnóstico y vuelve a enviarlo.',
        ]);

        // Regresa a la pantalla donde se tomó la decisión (inicio o Autorizaciones).
        return redirect()
            ->back(fallback: route('cliente.autorizaciones'))
            ->with(
                'success',
                'La reparación fue rechazada. El mecánico deberá revisar el diagnóstico.'
            );
    }
}