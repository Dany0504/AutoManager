<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MechanicStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MechanicStatusController extends Controller
{
    private const STEPS = [
        'pendiente',
        'diagnostico',
        'esperando_aprobacion',
        'en_proceso',
        'control_calidad',
        'listo',
    ];

    public function index(Request $request)
    {
        $appointments = Appointment::with(['client.user', 'vehicle'])
            ->where('mechanic_id', Auth::id())
            ->whereNotNull('intake_registered_at')
            ->orderByDesc('appointment_date')
            ->orderByDesc('appointment_time')
            ->get();

        $cita = null;

        if ($request->filled('cita')) {
            $cita = Appointment::with(['client.user', 'vehicle'])
                ->where('mechanic_id', Auth::id())
                ->whereNotNull('intake_registered_at')
                ->findOrFail($request->query('cita'));
        } elseif ($appointments->isNotEmpty()) {
            $cita = $appointments->first();
        }

        $logs = $cita
            ? MechanicStatusLog::where('appointment_id', $cita->id)
                ->with('mechanic')
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->get()
            : collect();

        return view('mecanico.ordenes.estatus', compact(
            'appointments',
            'cita',
            'logs'
        ));
    }

    public function update(Request $request, Appointment $cita)
    {
        $validated = $request->validate([
            'action' => ['required', 'in:note,advance'],
            'note' => ['nullable', 'string', 'max:3000'],
        ]);

        if (
            $validated['action'] === 'note'
            && blank($validated['note'] ?? null)
        ) {
            throw ValidationException::withMessages([
                'note' => 'Escribe una nota antes de guardarla.',
            ]);
        }

        $message = DB::transaction(function () use ($cita, $validated) {
            $appointment = Appointment::whereKey($cita->id)
                ->lockForUpdate()
                ->firstOrFail();

            abort_unless(
                (int) $appointment->mechanic_id === (int) Auth::id(),
                403,
                'Esta cita no está asignada a tu usuario.'
            );

            abort_unless(
                $appointment->intake_registered_at !== null,
                403,
                'Primero debes registrar el ingreso del vehículo.'
            );

            $previousStatus = $appointment->status;
            $newStatus = $previousStatus;

            if ($validated['action'] === 'advance') {
                $nextStatuses = [
                    'esperando_aprobacion' => 'en_proceso',
                    'en_proceso' => 'control_calidad',
                    'control_calidad' => 'listo',
                ];

                if (!isset($nextStatuses[$previousStatus])) {
                    throw ValidationException::withMessages([
                        'action' => 'La orden no puede avanzar desde su estado actual.',
                    ]);
                }

                if ($previousStatus === 'esperando_aprobacion') {
                    /*
                     * Se aceptan los dos nombres habituales
                     * de autorización para compatibilidad.
                     */
                    $authorized = in_array(
                        $appointment->authorization_status,
                        ['autorizado', 'aprobado'],
                        true
                    );

                    if (!$authorized) {
                        throw ValidationException::withMessages([
                            'action' => 'El cliente todavía no ha autorizado el presupuesto.',
                        ]);
                    }

                    if (!$appointment->authorized_at) {
                        throw ValidationException::withMessages([
                            'action' => 'Falta registrar la fecha de autorización del cliente.',
                        ]);
                    }
                }

                $newStatus = $nextStatuses[$previousStatus];

                $appointment->update([
                    'status' => $newStatus,
                ]);
            }

            MechanicStatusLog::create([
                'appointment_id' => $appointment->id,
                'mechanic_id' => Auth::id(),
                'previous_status' => $previousStatus,
                'new_status' => $newStatus,
                'note' => $validated['note'] ?? null,
            ]);

            return $validated['action'] === 'advance'
                ? 'Estatus actualizado correctamente.'
                : 'Nota del técnico guardada correctamente.';
        });

        return redirect()
            ->route('mecanico.ordenes.estatus', [
                'cita' => $cita->id,
            ])
            ->with('success', $message);
    }
}