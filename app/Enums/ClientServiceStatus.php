<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum ClientServiceStatus: string
{
    use EnumOptions;

    case Pending = 'pending';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
}
