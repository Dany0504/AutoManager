<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking');
    }

    public function track(Request $request)
    {
        $request->validate([
            'folio' => 'required|string'
        ]);

        $appointment = Appointment::with('vehicle')
            ->where('folio', $request->folio)
            ->first();

        if (!$appointment) {
            return back()->with('error', 'No se encontró ningún vehículo con ese folio.')
                ->withInput();
        }

        return view('tracking', compact('appointment'));
    }
}