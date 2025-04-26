<?php

namespace App\Models;

use App\Enums\RoomType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripPrice extends Model
{
    use HasFactory;

    protected $guarded  = ['id'];

    protected $casts = [
        'room_type' => RoomType::class,
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
