<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum UserStatus: string
{
    use EnumOptions;

    case Active = 'active';
    case Pending = 'pending';
    case Banned = 'banned';
}
