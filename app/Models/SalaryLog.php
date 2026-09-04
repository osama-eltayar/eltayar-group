<?php

namespace App\Models;

use App\Traits\LogsActivityWithBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalaryLog extends Model
{
    use HasFactory;
    use LogsActivityWithBranch;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'salary_id',
        'amount',
        'paid_at',
        'for_month',
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
            'for_month' => 'date',
        ];
    }

    public function salary(): BelongsTo
    {
        return $this->belongsTo(Salary::class);
    }
}
