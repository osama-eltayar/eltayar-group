<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum UserStatus: string implements HasLabel
{
    use EnumOptions;

    case Active = 'active';
    case Pending = 'pending';
    case Banned = 'banned';
}
