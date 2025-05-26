<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'message',
        'notifyBy',
        'seen',
    ];

    // Relationship to User (Assuming each notification belongs to one user)
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
