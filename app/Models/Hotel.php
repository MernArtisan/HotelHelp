<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'location',
        'address',
        'manager',
        'supervisor',
        'management_company',
        'ownership_group',
        'tax_location_code',
        'latitude',
        'longitude',
        'notes',
        'status',
        'contact',
        'email',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function miscellaneousItems()
    {
        return $this->hasMany(Miscellaneous::class);
    }

    public function miscellaneousFields()
    {
        return $this->hasMany(MiscellaneousEmployeeField::class);
    }
    public function revenues()
    {
        return $this->hasMany(Revenue::class);
    }
}
