<?php

namespace App\Models;

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
        'amount',
        'currency_code',
        'payment_method',
        'type',
        'notes'
    ];

    protected $casts = [
        'amount' => 'integer'
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
}
