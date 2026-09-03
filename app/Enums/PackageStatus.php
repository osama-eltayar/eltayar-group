<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum PackageStatus: string implements HasLabel
{
    use EnumOptions;
    //
    case DRAFT = 'draft';
    case Active = 'active';
}
