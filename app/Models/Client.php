<?php

namespace App\Models;

use App\Enums\ClientStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'name_en',
        'name_ar',
        'national_number',
        'passport_number',
        'factory_number',
        'passport_ended_at',
        'date_of_birth',
        'parent_id',
        'status',
        'notes',
    ];

    protected $casts = [
        'status' => ClientStatus::class,
        'date_of_birth' => 'date',
        'passport_ended_at' => 'date',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function omraClients(): HasMany
    {
        return $this->hasMany(OmraClient::class);
    }

    public function hajClients(): HasMany
    {
        return $this->hasMany(HajClient::class);
    }

    public function omras(): BelongsToMany
    {
        return $this->belongsToMany(Omra::class, 'omra_clients')
            ->withPivot(['booking_id', 'room_type', 'price', 'discount_amount', 'final_price', 'notes'])
            ->withTimestamps();
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function clientServices(): HasMany
    {
        return $this->hasMany(ClientService::class);
    }

    public function phones(): HasMany
    {
        return $this->hasMany(ClientPhone::class);
    }

    public function defaultPhone(): HasOne
    {
        return $this->hasOne(ClientPhone::class)->where('is_default', true);
    }

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->name_ar ?: (string) $this->name_en,
        );
    }
}
