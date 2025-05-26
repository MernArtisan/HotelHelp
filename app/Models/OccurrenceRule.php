<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OccurrenceRule extends Model
{
    use HasFactory;
    protected $table = 'occurrence_rules';
    protected $fillable = [
        'rule_name',
        'description',
        'time_of_occurrence',
    ];
}
