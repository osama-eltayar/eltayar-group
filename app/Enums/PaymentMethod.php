<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel
{
    use EnumOptions;

    case CASH = 'cash';
    case BANK = 'bank';
    case VISA = 'visa';

    public function getLabel(): string
    {
        return __("enums.payment_methods.{$this->value}");
    }
}
