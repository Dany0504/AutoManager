<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * Nombre visible de cada estado de la orden.
     * Úsalo en las vistas con $cita->status_label
     * o Appointment::statusLabel($estado).
     */
    public const STATUS_LABELS = [
        'pendiente' => 'Pendiente',
        'diagnostico' => 'Diagnóstico',
        'esperando_aprobacion' => 'Esperando autorización',
        'en_proceso' => 'En proceso',
        'control_calidad' => 'Control de calidad',
        'listo' => 'Listo para entrega',
        'entregado' => 'Entregado',
        'rechazado' => 'Rechazado',
        'completado' => 'Completado',
        'cancelado' => 'Cancelado',
    ];

    /**
     * Estados de una orden terminada: ya no requiere trabajo del mecánico,
     * sale de "Rastrear orden" y pasa al historial del cliente.
     * El flujo del mecánico cierra las órdenes con "entregado".
     */
    public const FINISHED_STATUSES = ['entregado', 'completado', 'cancelado'];

    public static function statusLabel(?string $status): string
    {
        if ($status === null || $status === '') {
            return 'Sin estado';
        }

        return self::STATUS_LABELS[$status]
            ?? ucfirst(str_replace('_', ' ', $status));
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusLabel($this->status);
    }

    protected $fillable = [
    'folio',
    'client_id',
    'vehicle_id',
    'mechanic_id',
    'service_type',
    'appointment_date',
    'appointment_time',
    'status',
    'notes',
    'diagnosis',
    'estimated_cost',
    'authorization_status',
    'diagnosis_submitted_at',
    'authorized_at'
];

protected $casts = [
    'appointment_date' => 'date',
    'diagnosis_submitted_at' => 'datetime',
    'authorized_at' => 'datetime',
    'estimated_cost' => 'decimal:2',
];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function mechanic()
    {
        return $this->belongsTo(User::class, 'mechanic_id');
    }

    public function orderItems()
    {
        return $this->hasMany(
            \App\Models\MechanicOrderItem::class,
            'appointment_id'
        );
    }
}