<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'task_id', 'service', 'time', 'price_per_unit', 'total','start_date','end_date','employee_id','platform_fee'
    ];   
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
