<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripClient extends Model
{
    use HasFactory;

    protected $fillable = ['client_id',
        'trip_id',
        'room_type',
        'price',
        'total_price',
        'discount_amount',
        'final_price',
        'balance',
        'parent_id',
        'is_dependent',
        'notes'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
