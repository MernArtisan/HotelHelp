<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'total_amount',
        'status'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
    public function revenues()
    {
        return $this->hasMany(Revenue::class);
    }
}
