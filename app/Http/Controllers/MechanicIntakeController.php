<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MechanicIntakeController extends Controller
{
    public function create(Request $request)
    {
        $appointments = Appointment::with(['client.user', 'vehicle'])
            ->where('mechanic_id', auth()->id())
            ->whereIn('status', [
                'pendiente',
                'diagnostico',
                'en_proceso',
            ])
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        $selectedAppointment = null;

        if ($request->filled('cita')) {
            $selectedAppointment = $appointments->firstWhere(
                'id',
                (int) $request->query('cita')
            );

            abort_unless($selectedAppointment, 404);
        }

        return view('mecanico.ordenes.create', compact(
            'appointments',
            'selectedAppointment'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'appointment_id' => ['required', 'integer'],
            'intake_mileage' => ['required', 'integer', 'min:0', 'max:9999999'],
            'intake_fuel_level' => [
                'required',
                Rule::in(['Vacio', '1/4', '1/2', '3/4', 'Lleno']),
            ],
            'intake_customer_description' => ['required', 'string', 'max:5000'],
            'intake_observations' => ['nullable', 'string', 'max:5000'],

            'photo_front' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'photo_left' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'photo_right' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'photo_rear' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $appointment = Appointment::where('mechanic_id', auth()->id())
            ->whereIn('status', [
                'pendiente',
                'diagnostico',
                'en_proceso',
            ])
            ->findOrFail($data['appointment_id']);

        if ($appointment->intake_registered_at !== null) {
            return redirect()
                ->route('mecanico.ordenes.create', ['cita' => $appointment->id])
                ->with('error', 'El ingreso de esta cita ya fue registrado.');
        }

        $photoFields = [
            'photo_front' => 'intake_photo_front',
            'photo_left' => 'intake_photo_left',
            'photo_right' => 'intake_photo_right',
            'photo_rear' => 'intake_photo_rear',
        ];

        $uploadedPaths = [];

        try {
            foreach ($photoFields as $input => $column) {
                if ($request->hasFile($input)) {
                    $uploadedPaths[$column] = $request->file($input)
                        ->store('appointment-intakes/' . $appointment->id, 'public');
                }
            }

            DB::transaction(function () use ($appointment, $data, $uploadedPaths) {
                $locked = Appointment::whereKey($appointment->id)
                    ->where('mechanic_id', auth()->id())
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($locked->intake_registered_at !== null) {
                    abort(409, 'El ingreso ya fue registrado.');
                }

                $locked->intake_mileage = $data['intake_mileage'];
                $locked->intake_fuel_level = $data['intake_fuel_level'];
                $locked->intake_customer_description = $data['intake_customer_description'];
                $locked->intake_observations = $data['intake_observations'] ?? null;

                foreach ($uploadedPaths as $column => $path) {
                    $locked->{$column} = $path;
                }

                $locked->intake_registered_at = now();
                $locked->save();
            });
        } catch (\Throwable $e) {
            foreach ($uploadedPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            throw $e;
        }

        return redirect()
            ->route('mecanico.ordenes.create', ['cita' => $appointment->id])
            ->with('success', 'Ingreso del vehículo registrado correctamente.');
    }
}
