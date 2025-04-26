<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'booking_id',
        'room_type',
        'price',
        'discount_amount',
        'final_price',
        'notes'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

}
