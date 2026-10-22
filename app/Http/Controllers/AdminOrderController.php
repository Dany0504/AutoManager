<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $estado = $request->query('estado', 'todos');

        $estadosPermitidos = [
            'todos',
            'pendiente',
            'en_proceso',
            'diagnostico',
            'listo',
            'completado',
        ];

        if (!in_array($estado, $estadosPermitidos, true)) {
            $estado = 'todos';
        }

        $ordenes = Appointment::query()
            ->with(['client', 'vehicle', 'mechanic'])
            ->when(
                $estado !== 'todos',
                fn ($query) => $query->where('status', $estado)
            )
            ->orderByDesc('appointment_date')
            ->get();

        return view('admin.ordenes.index', compact(
            'ordenes',
            'estado'
        ));
    }
    public function show(\App\Models\Appointment $orden)
    {
        $orden->load(['client.user', 'vehicle', 'mechanic']);

        return view('admin.ordenes.show', compact('orden'));
    }
}