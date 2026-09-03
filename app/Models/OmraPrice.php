<?php

namespace App\Models;

use App\Enums\RoomType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OmraPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'omra_id',
        'room_type',
        'price',
        'is_active',
    ];

    protected $casts = [
        'room_type' => RoomType::class,
        'is_active' => 'boolean',
        'price' => 'integer',
    ];

    public function omra(): BelongsTo
    {
        return $this->belongsTo(Omra::class);
    }
}
