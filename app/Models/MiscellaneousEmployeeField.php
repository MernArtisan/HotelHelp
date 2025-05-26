<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiscellaneousEmployeeField extends Model
{
    use HasFactory;
    protected $fillable = ['employee_id', 'hotel_id', 'field_name', 'field_value'];

    // Relationship to Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Relationship to Hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
