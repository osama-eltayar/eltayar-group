<?php

namespace App\Models;

use App\Enums\ClientStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        'national_number',
        'passport_number',
        'date_of_birth',
        'parent_id',
        'status',
        'notes'
    ];

    protected $casts = [
        'status' => ClientStatus::class,
        'date_of_birth' => 'date',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
}
