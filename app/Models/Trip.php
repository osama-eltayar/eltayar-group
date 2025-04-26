<?php

namespace App\Models;

use App\Enums\TripActivity;
use App\Enums\TripStatus;
use App\Enums\TripType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $guarded = ['name',
        'description',
        'started_at',
        'ended_at',
        'status',
        'activity',
        'type',
        'maximum_allowed',];

    protected $casts = [
        'started_at' => 'date',
        'ended_at' => 'date',
        'status' => TripStatus::class,
        'activity' => TripActivity::class,
        'type' => TripType::class,
    ];

    public function tripClients()
    {
        return $this->hasMany(TripClient::class);
    }

    public function tripPrices()
    {
        return $this->hasMany(TripPrice::class);
    }
}
