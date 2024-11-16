<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum TripActivity: string
{
    use EnumOptions;
    case Omra = 'omra';
}
