<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
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

        return redirect()
            ->route('cliente.autorizaciones')
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

        return redirect()
            ->route('cliente.autorizaciones')
            ->with(
                'success',
                'La reparación fue rechazada. El mecánico deberá revisar el diagnóstico.'
            );
    }
}