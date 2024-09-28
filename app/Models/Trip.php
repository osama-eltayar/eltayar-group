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

    protected $guarded = ['id'];

    protected $casts = [
        'started_at' => 'date',
        'ended_at' => 'date',
        'status' => TripStatus::class,
        'activity' => TripActivity::class,
        'type' => TripType::class,
    ];
}
