<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum PackageType: string implements HasLabel
{
    use EnumOptions;
    case Flight = 'flight';
}
