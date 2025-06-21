<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum Currency: string
{
    use EnumOptions;
    
    case SAUDI_RIYAL = 'SAR';
    case EGYPTIAN_POUND = 'EGP';

    public function label(): string
    {
        return __("enums.currencies.{$this->value}");
    }
}
