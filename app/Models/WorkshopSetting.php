<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkshopSetting extends Model
{
    protected $fillable = [
        'name',
        'rfc',
        'phone',
        'address',
        'email',
        'tax_percentage',
    ];

    protected $casts = [
        'tax_percentage' => 'decimal:2',
    ];
}
