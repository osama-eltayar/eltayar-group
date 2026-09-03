<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Enums\RoomType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'branch_id',
        'bookable_type',
        'bookable_id',
        'room_type',
        'price',
        'number_of_clients',
        'total_price',
        'discount_amount',
        'calculated_discount_amount',
        'final_price',
        'paid',
        'balance',
        'notes',
        'status',
    ];

    protected $casts = [
        'room_type' => RoomType::class,
        'price' => 'integer',
        'number_of_clients' => 'integer',
        'total_price' => 'integer',
        'discount_amount' => 'integer',
        'calculated_discount_amount' => 'integer',
        'final_price' => 'integer',
        'paid' => 'integer',
        'balance' => 'integer',
        'status' => BookingStatus::class,
    ];

    protected static function booted(): void
    {
        static::saving(function (self $booking): void {
            $booking->total_price = (int) $booking->price * (int) $booking->number_of_clients;
            $booking->final_price = max(0, $booking->total_price - (int) $booking->discount_amount - (int) $booking->calculated_discount_amount);
            $booking->balance = max(0, $booking->final_price - (int) $booking->paid);
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }

    public function omraClients(): HasMany
    {
        return $this->hasMany(OmraClient::class);
    }

    public function hajClients(): HasMany
    {
        return $this->hasMany(HajClient::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'omra_clients')
            ->withPivot(['omra_id', 'room_type', 'price', 'discount_amount', 'final_price', 'notes'])
            ->withTimestamps();
    }

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
