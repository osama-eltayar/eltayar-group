<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum TransactionType: string
{
    use EnumOptions;
    
    case IN = 'in';
    case OUT = 'out';

    public function label(): string
    {
        return __("enums.transaction_types.{$this->value}");
    }
} 