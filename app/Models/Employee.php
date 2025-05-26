<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'designation',
        'user_id',
        'employee_id',
        'hire_date',
        'status',
        'employee_type',
        'assigned_manager',
        'organization_manager',
        'pay_group_id',
        'pay_rate',
        'alternate_pay_rate',
        'location',
        'job_id',
        'gender',
        'contact',
        'message',
        'documents',
    ];

     public function user()
    {
        return $this->belongsTo(User::class);  // assuming Employee belongs to User
    }
    public function payGroup()
    {
        return $this->belongsTo(PayGroup::class, 'pay_group_id');
    }
    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function timecards()
    {
        return $this->hasMany(Timecard::class);
    }

    public function termination()
    {
        return $this->hasOne(Termination::class);
    }

    public function miscellaneousFields()
    {
        return $this->hasMany(MiscellaneousEmployeeField::class);
    }

    public function additionalChecks()
    {
        return $this->hasMany(AdditionalCheck::class);
    }
}
