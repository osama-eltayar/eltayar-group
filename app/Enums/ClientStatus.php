<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum ClientStatus: string implements HasLabel
{
    use EnumOptions;
    case Active = 'active';
    case Banned = 'banned';
}
