<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum Currency: string
{
    case SAUDI_RIYAL = 'SAR';
    case EGYPTIAN_POUND = 'EGP';

    public function label(): string
    {
        return __("enums.currencies.{$this->value}");
    }
}
