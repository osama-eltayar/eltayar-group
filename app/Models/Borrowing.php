<?php

namespace App\Models;

use App\Traits\LogsActivityWithBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Borrowing extends Model
{
    use HasFactory;
    use LogsActivityWithBranch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'amount',
        'paid',
        'remaining',
        'paid_at',
        'expected_at',
        'ended_at',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'paid' => 'integer',
            'remaining' => 'integer',
            'paid_at' => 'date',
            'expected_at' => 'date',
            'ended_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(BorrowingLog::class);
    }

    public function latestLog(): HasOne
    {
        return $this->hasOne(BorrowingLog::class)->latestOfMany('paid_at');
    }
}
