<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;
    protected $fillable = [
        'role',
        'eligibility_criteria',
        'holiday_entitlement',
        'shift',
        'holiday_start_date'
    ];

    
}
