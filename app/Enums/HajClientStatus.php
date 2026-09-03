<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum HajClientStatus: string implements HasLabel
{
    use EnumOptions;
    case NoShow = 'no_show';
    case Successful = 'successful';
    case Unsuccessful = 'unsuccessful';
    case Reserve = 'reserve';
    case Withdrawn = 'withdrawn';
}
