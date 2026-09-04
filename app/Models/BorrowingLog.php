<?php

namespace App\Models;

use App\Traits\LogsActivityWithBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowingLog extends Model
{
    use HasFactory;
    use LogsActivityWithBranch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'borrowing_id',
        'amount',
        'paid_at',
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
            'paid_at' => 'date',
        ];
    }

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }
}
