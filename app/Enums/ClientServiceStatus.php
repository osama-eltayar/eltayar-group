<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum ClientServiceStatus: string implements HasLabel
{
    use EnumOptions;

    case Pending = 'pending';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
