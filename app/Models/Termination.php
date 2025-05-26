<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Termination extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'employee_name',
        'hotel_name',
        'termination_reason',
        'termination_date',
        'additional_notes'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
