<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoundingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'role',
        'working_hours_rounding',
        'overtime_rounding',
        'break_time_rounding',
        'notes',
    ];
}

