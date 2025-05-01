<?php

namespace App\Models;

use App\Enums\RoomType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'room_type',
        'price',
        'is_active'
    ];

    protected $casts = [
        'room_type' => RoomType::class,
        'is_active' => 'boolean'
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
