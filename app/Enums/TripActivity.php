<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum TripActivity: string implements HasLabel
{
    use EnumOptions;
    case Omra = 'omra';
    case Hajj = 'hajj';
}
