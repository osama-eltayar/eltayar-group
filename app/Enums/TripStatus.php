<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum TripStatus: string
{
    use EnumOptions;
    //
    case DRAFT = 'draft';
    case Active = 'active';

    public function label()
    {
        return match ($this) {
            self::DRAFT => __('Trip Draft'),
            self::Active => __('Trip Acrive'),
        };
    }
}
