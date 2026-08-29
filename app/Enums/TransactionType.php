<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum TransactionType: string implements HasLabel
{
    use EnumOptions;

    case IN = 'in';
    case OUT = 'out';

    public function getLabel(): string
    {
        return __("enums.transaction_types.{$this->value}");
    }
}
