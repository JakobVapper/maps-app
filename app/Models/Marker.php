<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    protected $fillable = ['name', 'latitude', 'longitude', 'description'];
    
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];
}