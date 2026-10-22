<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentSetting extends Model
{
    protected $fillable = [
        'opening_time',
        'closing_time',
        'slot_duration',
        'break_start',
        'working_days',
        'services',
        'blocked_dates',
    ];

    protected $casts = [
        'working_days' => 'array',
        'services' => 'array',
        'blocked_dates' => 'array',
    ];
}
