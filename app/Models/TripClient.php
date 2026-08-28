<?php

namespace App\Models;

use App\Enums\RoomType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TripClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'trip_id',
        'booking_id',
        'room_type',
        'price',
        'discount_amount',
        'final_price',
        'notes',
    ];

    protected $casts = [
        'room_type' => RoomType::class,
        'price' => 'integer',
        'discount_amount' => 'integer',
        'final_price' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $tripClient): void {
            $tripClient->final_price = max(0, (int) $tripClient->price - (int) $tripClient->discount_amount);
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}
