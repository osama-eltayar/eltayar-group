<?php

namespace App\Models;

use Alkoumi\LaravelArabicNumbers\Numbers;
use App\Enums\Currency;
use App\Enums\PaymentMethod;
use App\Enums\TransactionType;
use App\Services\Booking\RecalculateBookingPaidService;
use App\Traits\LogsActivityWithBranch;
use Carbon\Carbon;
use Filament\Support\Facades\FilamentTimezone;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;
    use LogsActivityWithBranch;

    protected $fillable = [
        'branch_id',
        'user_id',
        'client_id',
        'transactionable_type',
        'transactionable_id',
        'about',
        'delivered_by',
        'amount',
        'currency_code',
        'payment_method',
        'type',
        'notes',
        'reviewed_by',
    ];

    protected $casts = [
        'amount' => 'integer',
        'currency_code' => Currency::class,
        'payment_method' => PaymentMethod::class,
        'type' => TransactionType::class,
    ];

    protected static function booted(): void
    {
        static::creating(function (self $transaction): void {
            $transaction->identifier ??= static::generateIdentifier($transaction->branch_id);
        });

        static::saved(function (self $transaction): void {
            static::recalculateBookingPaid($transaction->transactionable_type, $transaction->transactionable_id);

            $originalType = $transaction->getOriginal('transactionable_type');
            $originalId = $transaction->getOriginal('transactionable_id');

            if ($originalType !== $transaction->transactionable_type || $originalId !== $transaction->transactionable_id) {
                static::recalculateBookingPaid($originalType, $originalId);
            }
        });

        static::deleted(function (self $transaction): void {
            static::recalculateBookingPaid($transaction->transactionable_type, $transaction->transactionable_id);
        });
    }

    private static function recalculateBookingPaid(?string $transactionableType, ?int $transactionableId): void
    {
        if ($transactionableType !== Booking::class || $transactionableId === null) {
            return;
        }

        $booking = Booking::find($transactionableId);

        if ($booking) {
            app(RecalculateBookingPaidService::class)->execute($booking);
        }
    }

    public static function generateIdentifier(?int $branchId): string
    {
        $localNow = Carbon::now(FilamentTimezone::get());
        $dayStart = $localNow->clone()->startOfDay()->utc();
        $dayEnd = $localNow->clone()->endOfDay()->utc();

        $sequence = static::query()
            ->where('branch_id', $branchId)
            ->whereBetween('created_at', [$dayStart, $dayEnd])
            ->count() + 1;

        return $localNow->format('Ymd')
            .str_pad((string) ($branchId ?? 0), 2, '0', STR_PAD_LEFT)
            .str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function isReviewed(): bool
    {
        return $this->reviewed_by !== null;
    }

    public function amountInArabic(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Numbers::TafqeetMoney($this->amount, $this->currency_code->value),
        );
    }
}
