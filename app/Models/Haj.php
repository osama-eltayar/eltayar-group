<?php

namespace App\Models;

use App\Enums\PackageStatus;
use App\Enums\PackageType;
use App\Traits\LogsActivityWithBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Haj extends Model
{
    use HasFactory;
    use LogsActivityWithBranch;

    protected $fillable = [
        'name',
        'description',
        'status',
        'type',
        'deposit_price',
        'full_price',
        'maximum_allowed',
        'passport_minimum_end_at',
    ];

    protected $casts = [
        'status' => PackageStatus::class,
        'type' => PackageType::class,
        'deposit_price' => 'integer',
        'full_price' => 'integer',
        'passport_minimum_end_at' => 'date',
    ];

    public function hajClients(): HasMany
    {
        return $this->hasMany(HajClient::class);
    }

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
