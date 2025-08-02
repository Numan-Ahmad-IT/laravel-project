<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'customer_name',
        'customer_email',
        'quantity',
        'total_amount',
        'purchase_date'
    ];

    protected $casts = [
        'purchase_date' => 'datetime',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}