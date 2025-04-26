<?php

namespace App\Models;

use App\Enums\RoomType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'trip_id',
        'room_type',
        'price',
        'number_of_clients',
        'total_price',
        'discount_amount',
        'final_price',
        'balance',
        'notes'
    ];

    protected $casts = [
        'room_type' => RoomType::class,
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function bookingClients()
    {
        return $this->hasMany(BookingClient::class,'client_id');
    }
}
