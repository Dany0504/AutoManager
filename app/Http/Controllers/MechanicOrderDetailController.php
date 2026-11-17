<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MechanicOrderItem;
use App\Models\MechanicStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MechanicOrderDetailController extends Controller
{
    /**
     * Pantalla anterior: ahora el trabajo se hace en la ficha de la orden.
     * Con ?cita=ID abre esa ficha; sin ella, regresa a Mis órdenes.
     */
    public function index(Request $request)
    {
        if ($request->filled('cita')) {
            return redirect()->route('mecanico.ordenes.ficha', (int) $request->query('cita'));
        }

        return redirect()->route('mecanico.dashboard');
    }

    /**
     * Enlace anterior a una cita: abre su ficha.
     */
    public function show(Appointment $cita)
    {
        return redirect()->route('mecanico.ordenes.ficha', $cita);
    }

    /**
     * Guardar borrador o solicitar autorización.
     */
    public function save(Request $request, Appointment $cita)
    {
        $this->validateAccess($cita);
        $this->validateEditable($cita);

        $validated = $request->validate([
            'diagnosis' => [
                'required',
                'string',
                'max:5000',
            ],
            'action' => [
                'required',
                'in:draft,submit',
            ],
            'items' => [
                'nullable',
                'array',
                'max:100',
            ],
            'items.*.type' => [
                'required',
                'in:servicio,refaccion',
            ],
            'items.*.name' => [
                'required',
                'string',
                'max:200',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
                'max:100000',
            ],
            'items.*.unit_price' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999.99',
                'decimal:0,2',
            ],
        ]);

        $items = array_values($validated['items'] ?? []);

        if ($validated['action'] === 'submit' && count($items) === 0) {
            throw ValidationException::withMessages([
                'items' => 'Agrega al menos un servicio o refacción antes de solicitar autorización.',
            ]);
        }

        /*
         * Calcular con centavos enteros para evitar
         * diferencias de precisión con decimales.
         */
        $totalCents = 0;

        foreach ($items as $item) {
            $priceCents = (int) round(
                ((float) $item['unit_price']) * 100
            );

            $totalCents += $priceCents * (int) $item['quantity'];
        }

        if ($totalCents > 999999999999) {
            throw ValidationException::withMessages([
                'items' => 'El total supera el máximo permitido.',
            ]);
        }

        DB::transaction(function () use (
            $cita,
            $validated,
            $items,
            $totalCents
        ) {
            /*
             * Bloquear el registro durante la operación
             * para evitar ediciones simultáneas.
             */
            $lockedCita = Appointment::whereKey($cita->id)
                ->lockForUpdate()
                ->firstOrFail();

            $this->validateAccess($lockedCita);
            $this->validateEditable($lockedCita);

            MechanicOrderItem::where(
                'appointment_id',
                $lockedCita->id
            )->delete();

            foreach ($items as $item) {
                MechanicOrderItem::create([
                    'appointment_id' => $lockedCita->id,
                    'type' => $item['type'],
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);
            }

            $isSubmit = $validated['action'] === 'submit';
            $previousStatus = $lockedCita->status;

            $lockedCita->update([
                'diagnosis' => $validated['diagnosis'],
                'estimated_cost' => number_format(
                    $totalCents / 100,
                    2,
                    '.',
                    ''
                ),
                'status' => $isSubmit
                    ? 'esperando_aprobacion'
                    : 'diagnostico',
                // Al guardar un borrador se conserva un rechazo previo
                // para que el mecánico siga viendo el aviso.
                'authorization_status' => $isSubmit
                    ? 'pendiente'
                    : $lockedCita->authorization_status,
                'diagnosis_submitted_at' => $isSubmit
                    ? now()
                    : null,
            ]);

            if ($isSubmit) {
                MechanicStatusLog::create([
                    'appointment_id' => $lockedCita->id,
                    'mechanic_id' => Auth::id(),
                    'previous_status' => $previousStatus,
                    'new_status' => 'esperando_aprobacion',
                    'note' => 'Presupuesto enviado al cliente por $'
                        . number_format($totalCents / 100, 2)
                        . ' (' . count($items) . ' concepto(s)).',
                ]);
            }
        });

        return redirect()
            ->route('mecanico.ordenes.ficha', $cita)
            ->with(
                'success',
                $validated['action'] === 'submit'
                    ? 'Presupuesto enviado para autorización del cliente.'
                    : 'Diagnóstico y conceptos guardados correctamente.'
            );
    }

    /**
     * Comprobar asignación e ingreso.
     */
    private function validateAccess(Appointment $cita): void
    {
        abort_unless(
            (int) $cita->mechanic_id === (int) Auth::id(),
            403,
            'Esta cita no está asignada a tu usuario.'
        );

        abort_unless(
            $cita->intake_registered_at !== null,
            403,
            'Primero debes registrar el ingreso del vehículo.'
        );
    }

    /**
     * Impedir cambios sobre presupuestos enviados,
     * autorizados, rechazados o finalizados.
     */
    private function validateEditable(Appointment $cita): void
    {
        abort_unless(
            in_array($cita->status, [
                'pendiente',
                'diagnostico',
            ], true),
            403,
            'Esta orden ya no permite modificar el presupuesto.'
        );
    }
}