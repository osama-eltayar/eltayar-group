<?php

namespace App\Models;

use App\Enums\RoomType;
use App\Services\Omra\RecalculateOmraBookingService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OmraClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'client_id',
        'omra_id',
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
        static::saving(function (self $omraClient): void {
            $omraClient->final_price = max(0, (int) $omraClient->price - (int) $omraClient->discount_amount);
        });

        static::saved(function (self $omraClient): void {
            if ($omraClient->booking) {
                app(RecalculateOmraBookingService::class)->execute($omraClient->booking);
            }
        });

        static::deleted(function (self $omraClient): void {
            if ($omraClient->booking) {
                app(RecalculateOmraBookingService::class)->execute($omraClient->booking);
            }
        });
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function omra(): BelongsTo
    {
        return $this->belongsTo(Omra::class);
    }
}
