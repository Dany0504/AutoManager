<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function track(Request $request)
    {
        $request->validate([
            'folio' => 'required|string'
        ]);

        $appointment = Appointment::with('vehicle')
            ->where('folio', trim($request->folio))
            ->first();

        if (!$appointment) {
            return response()->json([
                'message' => 'No se encontró ningún vehículo con ese folio.'
            ], 404);
        }

        return response()->json([
            'folio' => $appointment->folio,

            'vehicle' => [
                'brand' => $appointment->vehicle?->brand,
                'model' => $appointment->vehicle?->model,
                'year' => $appointment->vehicle?->year,
                'plates' => $appointment->vehicle?->plates,
            ],

            'service_type' => $appointment->service_type,
            'status' => $appointment->status,
            'notes' => $appointment->notes,
        ]);
    }
}