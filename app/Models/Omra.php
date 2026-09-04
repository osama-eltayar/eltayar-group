<?php

namespace App\Models;

use App\Enums\PackageStatus;
use App\Enums\PackageType;
use App\Traits\LogsActivityWithBranch;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use IntlDateFormatter;

class Omra extends Model
{
    use HasFactory;
    use LogsActivityWithBranch;

    protected $fillable = [
        'name',
        'description',
        'started_at',
        'ended_at',
        'status',
        'type',
        'maximum_allowed',
    ];

    protected $casts = [
        'started_at' => 'date',
        'ended_at' => 'date',
        'status' => PackageStatus::class,
        'type' => PackageType::class,
    ];

    public function omraClients(): HasMany
    {
        return $this->hasMany(OmraClient::class);
    }

    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(Client::class, 'omra_clients')
            ->withPivot(['booking_id', 'room_type', 'price', 'discount_amount', 'final_price', 'notes'])
            ->withTimestamps();
    }

    public function omraPrices(): HasMany
    {
        return $this->hasMany(OmraPrice::class);
    }

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    public static function generateHijriName(DateTimeInterface $startedAt): string
    {
        $hijriYear = (new IntlDateFormatter(
            'ar_SA@calendar=islamic',
            IntlDateFormatter::NONE,
            IntlDateFormatter::NONE,
            'UTC',
            IntlDateFormatter::TRADITIONAL,
            'yyyy',
        ))->format($startedAt);

        return "عمرة {$hijriYear}هـ";
    }
}
