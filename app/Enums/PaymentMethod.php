<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum PaymentMethod: string
{
    use EnumOptions;
    
    case CASH = 'cash';
    case BANK = 'bank';
    case VISA = 'visa';

    public function label(): string
    {
        return __("enums.payment_methods.{$this->value}");
    }
} 