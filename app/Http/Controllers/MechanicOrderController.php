<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MechanicStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Ficha única de orden del mecánico.
 *
 * Una sola pantalla por cita con cuatro pasos:
 * 1. Ingreso  2. Diagnóstico y presupuesto  3. Reparación  4. Entrega
 *
 * Los formularios de cada paso siguen enviándose a sus controladores
 * (MechanicIntakeController, MechanicOrderDetailController y
 * MechanicStatusController), que al terminar regresan a esta ficha.
 */
class MechanicOrderController extends Controller
{
    public const STEPS = [
        1 => ['title' => 'Ingreso', 'description' => 'Recepción del vehículo'],
        2 => ['title' => 'Diagnóstico y presupuesto', 'description' => 'Revisión y autorización del cliente'],
        3 => ['title' => 'Reparación', 'description' => 'Trabajo y control de calidad'],
        4 => ['title' => 'Entrega', 'description' => 'Vehículo listo y entregado'],
    ];

    public function show(Request $request, Appointment $cita)
    {
        abort_unless(
            (int) $cita->mechanic_id === (int) Auth::id(),
            403,
            'Esta cita no está asignada a tu usuario.'
        );

        $cita->load(['client.user', 'vehicle', 'orderItems']);

        $currentStep = self::currentStep($cita);

        // Se puede consultar un paso ya recorrido; los pasos futuros no.
        $step = (int) $request->query('paso', $currentStep);
        if ($step < 1 || $step > $currentStep) {
            $step = $currentStep;
        }

        $logs = MechanicStatusLog::where('appointment_id', $cita->id)
            ->with('mechanic')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        return view('mecanico.ordenes.ficha', [
            'cita' => $cita,
            'steps' => self::STEPS,
            'currentStep' => $currentStep,
            'step' => $step,
            'logs' => $logs,
        ]);
    }

    /**
     * Paso en el que se encuentra la orden según su avance.
     */
    public static function currentStep(Appointment $cita): int
    {
        if ($cita->intake_registered_at === null) {
            return 1;
        }

        return match ($cita->status) {
            'pendiente', 'diagnostico', 'esperando_aprobacion' => 2,
            'en_proceso', 'control_calidad' => 3,
            default => 4, // listo, entregado, completado
        };
    }

    /**
     * Texto corto de la siguiente acción, para la lista de órdenes.
     */
    public static function nextActionLabel(Appointment $cita): string
    {
        if ($cita->intake_registered_at === null) {
            return 'Registrar ingreso';
        }

        return match ($cita->status) {
            'pendiente', 'diagnostico' => 'Diagnosticar',
            'esperando_aprobacion' => 'Esperando cliente',
            'en_proceso', 'control_calidad' => 'Continuar reparación',
            'listo' => 'Entregar',
            default => 'Ver orden',
        };
    }
}
