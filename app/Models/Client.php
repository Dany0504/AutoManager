<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
    ];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'client_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'client_id');
    }
}