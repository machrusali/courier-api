<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'phone_number',
    'vehicle_type',
    'level',
    'is_active',
])]
class Courier extends Model
{
    use HasFactory;

    protected $casts = [
        'level' => 'integer',
        'is_active' => 'boolean',
    ];
}
