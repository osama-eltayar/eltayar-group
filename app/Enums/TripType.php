<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum TripType: string
{
    use EnumOptions;
    case Flight = 'flight' ;
}
