<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'client_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'client_id');
    }
}