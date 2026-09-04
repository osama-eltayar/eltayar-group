<?php

namespace App\Models;

use App\Traits\LogsActivityWithBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;
    use LogsActivityWithBranch;

    protected $fillable = [
        'name',
    ];

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function omraClients(): HasMany
    {
        return $this->hasMany(OmraClient::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
