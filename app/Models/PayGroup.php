<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayGroup extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'pay_frequency', 'payroll_input_method', 'payroll_type', 'normal_hours', 'pay_day_of_week', 'run_date', 'inpound_date', 'period_date', 'status'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'pay_group_id');
    }

}
