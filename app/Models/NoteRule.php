<?php
     
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteRule extends Model
{
    use HasFactory;

    // Allow mass assignment for these fields
    protected $fillable = [
        'rule_name',
        'rule_description',
        'effective_start_date',
        'effective_end_date',
        'associated_department',
        'notes',
    ];
}

