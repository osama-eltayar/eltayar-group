<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum ClientStatus: string
{
    use EnumOptions;
    case Active = 'active';
    case Banned = 'banned';
}
