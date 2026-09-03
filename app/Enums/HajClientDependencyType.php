<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum HajClientDependencyType: string implements HasLabel
{
    use EnumOptions;
    case Independent = 'independent';
    case Dependent = 'dependent';
}
