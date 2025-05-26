<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timecard extends Model
{
    use HasFactory;
    protected $table = 'timecards';
    protected $fillable = [
        'employee_id', 
        'start_time', 
        'break_start', 
        'break_end', 
        'end_time',
        'total_amount',
        'total_hours',
        'date',
        'status'
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
