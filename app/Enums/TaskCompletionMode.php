<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum TaskCompletionMode: string implements HasLabel
{
    use EnumOptions;

    case RequireAll = 'require_all';
    case RequireAny = 'require_any';
}
