<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'hotel_id',
        'task_number',
        'task_date',
        'due_date',
        'total_amount',
        'status',
    ];
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    
    public function items()
    {
        return $this->hasMany(TaskItem::class);
    }
}
