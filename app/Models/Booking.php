<?php

namespace App\Models;

use App\Enums\RoomType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
        'paid',
        'balance',
        'notes',
    ];

    protected $casts = [
        'room_type' => RoomType::class,
        'price' => 'integer',
        'number_of_clients' => 'integer',
        'total_price' => 'integer',
        'discount_amount' => 'integer',
        'final_price' => 'integer',
        'paid' => 'integer',
        'balance' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $booking): void {
            $booking->total_price = (int) $booking->price * (int) $booking->number_of_clients;
            $booking->final_price = max(0, $booking->total_price - (int) $booking->discount_amount);
            $booking->balance = max(0, $booking->final_price - (int) $booking->paid);
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class, 'trip_id');
    }

    public function tripClients(): HasMany
    {
        return $this->hasMany(TripClient::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'trip_clients')
            ->withPivot(['trip_id', 'room_type', 'price', 'discount_amount', 'final_price', 'notes'])
            ->withTimestamps();
    }

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
