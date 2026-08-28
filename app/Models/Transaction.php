<?php

namespace App\Models;

use Alkoumi\LaravelArabicNumbers\Numbers;
use App\Enums\Currency;
use App\Enums\PaymentMethod;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
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
