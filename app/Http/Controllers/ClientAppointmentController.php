<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientAppointmentController extends Controller
{
    /**
     * Mostrar pantalla para agendar cita.
     */
    public function create()
    {
        $user = Auth::user();
        $client = $user->client;

        $vehicles = $client
            ? $client->vehicles()->orderBy('brand')->get()
            : collect();

        return view('cliente.agendar-cita', compact('vehicles'));
    }

    /**
     * Guardar la cita del cliente.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $client = $user->client;

        /*
         * El usuario debe tener un perfil de cliente.
         */
        if (!$client) {
            return back()
                ->withErrors([
                    'client' => 'No se encontró un perfil de cliente asociado a tu cuenta.'
                ])
                ->withInput();
        }

        /*
         * Validar los datos enviados desde
         * el formulario de Agendar cita.
         */
        $validated = $request->validate([

            'vehicle_id' => [
                'required',
                'integer',
                'exists:vehicles,id'
            ],

            'service_type' => [
                'required',
                'string',
                'max:100'
            ],

            'appointment_date' => [
                'required',
                'date',
                'after_or_equal:today'
            ],

            'appointment_time' => [
                'required',
                'date_format:H:i'
            ],

            /*
             * Descripción de la falla escrita
             * por el cliente.
             */
            'notes' => [
                'nullable',
                'string',
                'max:1000'
            ],

        ]);

        /*
         * SEGURIDAD
         *
         * Comprobar que el vehículo seleccionado
         * realmente pertenece al cliente que
         * inició sesión.
         */
        $vehicle = Vehicle::where(
                'id',
                $validated['vehicle_id']
            )
            ->where(
                'client_id',
                $client->id
            )
            ->firstOrFail();

        /*
         * COMPROBAR HORARIO
         *
         * Evitar que dos citas ocupen exactamente
         * la misma fecha y hora.
         */
        $occupied = Appointment::whereDate(
                'appointment_date',
                $validated['appointment_date']
            )
            ->where(
                'appointment_time',
                $validated['appointment_time']
            )
            ->whereNotIn(
                'status',
                ['cancelado']
            )
            ->exists();

        if ($occupied) {
            return back()
                ->withErrors([
                    'appointment_time' =>
                        'Ese horario ya no está disponible. Selecciona otro.'
                ])
                ->withInput();
        }

        /*
         * GENERAR FOLIO ÚNICO
         *
         * Ejemplo:
         * AM-2026-000015
         */
        do {

            $folio =
                'AM-' .
                now()->format('Y') .
                '-' .
                str_pad(
                    (string) random_int(1, 999999),
                    6,
                    '0',
                    STR_PAD_LEFT
                );

        } while (
            Appointment::where('folio', $folio)->exists()
        );

        /*
         * CREAR CITA
         */
        Appointment::create([

            'folio' => $folio,

            'client_id' => $client->id,

            'vehicle_id' => $vehicle->id,

            'mechanic_id' => null,

            'service_type' =>
                $validated['service_type'],

            'appointment_date' =>
                $validated['appointment_date'],

            'appointment_time' =>
                $validated['appointment_time'],

            'status' => 'pendiente',

            /*
             * Aquí guardamos la falla escrita
             * por el cliente.
             */
            'notes' =>
                $validated['notes'] ?? null,

        ]);

        /*
         * Regresar a Agendar cita mostrando
         * el folio generado.
         */
        return redirect()
            ->route('cliente.citas.create')
            ->with(
                'success',
                'Tu cita fue agendada correctamente. Folio: ' . $folio
            );
    }
}