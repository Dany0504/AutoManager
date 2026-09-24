<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleCatalog extends Model
{
    protected $fillable = [
        'brand',
        'model',
        'year',
        'engine'
    ];
}