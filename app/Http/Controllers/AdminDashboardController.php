<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Vehicle;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $citasHoy = Appointment::whereDate('appointment_date', today())->count();

        $totalVehiculos = Vehicle::count();

        return view('admin.dashboard', compact(
            'citasHoy',
            'totalVehiculos'
        ));
    }
}