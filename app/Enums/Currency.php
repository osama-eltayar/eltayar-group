<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum Currency: string implements HasLabel
{
    use EnumOptions;

    case SAUDI_RIYAL = 'SAR';
    case EGYPTIAN_POUND = 'EGP';

    public function getLabel(): string
    {
        return __("enums.currencies.{$this->value}");
    }
}
