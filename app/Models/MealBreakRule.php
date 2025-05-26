<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealBreakRule extends Model
{
    use HasFactory;
    protected $fillable = [
        'role',
        'meal_break',
        'break_duration',
        'break_frequency',
    ];
}
