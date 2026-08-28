<?php

namespace App\Models;

use App\Enums\TripActivity;
use App\Enums\TripStatus;
use App\Enums\TripType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'started_at',
        'ended_at',
        'status',
        'activity',
        'type',
        'maximum_allowed',
    ];

    protected $casts = [
        'started_at' => 'date',
        'ended_at' => 'date',
        'status' => TripStatus::class,
        'activity' => TripActivity::class,
        'type' => TripType::class,
    ];

    public function tripClients(): HasMany
    {
        return $this->hasMany(TripClient::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'trip_clients')
            ->withPivot(['booking_id', 'room_type', 'price', 'discount_amount', 'final_price', 'notes'])
            ->withTimestamps();
    }

    public function tripPrices(): HasMany
    {
        return $this->hasMany(TripPrice::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
