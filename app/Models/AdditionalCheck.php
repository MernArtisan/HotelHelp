<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalCheck extends Model
{
    use HasFactory;

    // Specify the table name (optional if using convention)
    protected $table = 'additional_checks';

    // Specify the fillable fields
    protected $fillable = [
        'employee_id',
        'check_date',
        'amount',
        'description',
        'created_by',
    ];

    /**
     * Relationship: An additional check belongs to an employee.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
