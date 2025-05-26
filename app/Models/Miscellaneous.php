<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Miscellaneous extends Model
{
    use HasFactory;

    protected $table = 'miscellaneous';

    protected $fillable = [
        'hotel_id',
        'item_name',
        'description',
        'category',
        'value',
    ];

    // Hotel ke sath relationship define karna
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
