<?php

namespace App\Models;

use App\Enums\ClientServiceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ClientService extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_name',
        'service_date',
        'amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'service_date' => 'datetime',
        'amount' => 'integer',
        'status' => ClientServiceStatus::class,
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
