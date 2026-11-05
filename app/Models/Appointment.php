<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
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