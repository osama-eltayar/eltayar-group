<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientService extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_name',
        'service_date',
        'amount',
        'status',
        'notes'
    ];

    protected $casts = [
        'service_date' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
