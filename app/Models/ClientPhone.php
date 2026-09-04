<?php

namespace App\Models;

use App\Traits\LogsActivityWithBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientPhone extends Model
{
    use HasFactory;
    use LogsActivityWithBranch;

    protected $fillable = [
        'client_id',
        'phone',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saved(function (self $clientPhone): void {
            if ($clientPhone->is_default) {
                static::query()
                    ->where('client_id', $clientPhone->client_id)
                    ->whereKeyNot($clientPhone->id)
                    ->update(['is_default' => false]);
            }
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
