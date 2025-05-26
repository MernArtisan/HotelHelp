<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id',
        'hotel_id',
        'total_amount',
        'paid_amount',
        'due_amount',
        'employees_amount',
        'net_amount',
        'profit_amount',
        'status',
    ];

    /**
     * Relationship with the Invoice model.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Relationship with the Hotel model.
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
