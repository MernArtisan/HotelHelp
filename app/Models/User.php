<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'address',
        'ssn',
        'birth_date',
        'marital_status',
        'contact_number',
        'gender',
        'about',
        'image',
        'fcm_token'
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'ssn',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'birth_date' => 'date',
    ];
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'id');
    }
}
