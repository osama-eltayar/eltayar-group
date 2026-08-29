<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum TripType: string implements HasLabel
{
    use EnumOptions;
    case Flight = 'flight';
}
