<?php

namespace App\Models;

use Alkoumi\LaravelArabicNumbers\Numbers;
use App\Enums\Currency;
use App\Enums\PaymentMethod;
use App\Enums\TransactionType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


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
        'notes'
    ];

    protected $casts = [
        'amount' => 'integer',
        'currency_code' => Currency::class,
        'payment_method' => PaymentMethod::class,
        'type' => TransactionType::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function amountInArabic():Attribute
    {
        return Attribute::make(
            get: fn ($value) => Numbers::TafqeetMoney($this->amount,$this->currency_code->value),
        );
    }


}
