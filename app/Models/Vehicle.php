<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
    'client_id',
    'brand',
    'model',
    'year',
    'engine',
    'color',
    'plates',
    'vin',
    'mileage'
];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}