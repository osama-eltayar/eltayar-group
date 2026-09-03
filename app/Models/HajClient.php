<?php

namespace App\Models;

use App\Enums\HajClientDependencyType;
use App\Enums\HajClientRelationType;
use App\Enums\HajClientStatus;
use App\Enums\PackageStatus;
use App\Services\Haj\RecalculateHajBookingService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HajClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'status',
        'haj_id',
        'booking_id',
        'discount_amount',
        'dependency_type',
        'depends_on_haj_client_id',
        'relation_type',
        'notes',
    ];

    protected $casts = [
        'status' => HajClientStatus::class,
        'discount_amount' => 'integer',
        'dependency_type' => HajClientDependencyType::class,
        'relation_type' => HajClientRelationType::class,
    ];

    protected static function booted(): void
    {
        static::saved(function (self $hajClient): void {
            if ($hajClient->booking) {
                app(RecalculateHajBookingService::class)->execute($hajClient->booking);
            }
        });

        static::deleted(function (self $hajClient): void {
            if ($hajClient->booking) {
                app(RecalculateHajBookingService::class)->execute($hajClient->booking);
            }
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function haj(): BelongsTo
    {
        return $this->belongsTo(Haj::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function dependsOn(): BelongsTo
    {
        return $this->belongsTo(self::class, 'depends_on_haj_client_id');
    }

    public function dependents(): HasMany
    {
        return $this->hasMany(self::class, 'depends_on_haj_client_id');
    }

    public static function clientHasAnotherActiveHaj(int $clientId, int $hajId): bool
    {
        return static::query()
            ->where('client_id', $clientId)
            ->where('haj_id', '!=', $hajId)
            ->whereHas('haj', fn ($query) => $query->where('status', PackageStatus::Active))
            ->exists();
    }
}
