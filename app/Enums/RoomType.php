<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum RoomType: string implements HasLabel
{
    use EnumOptions;
    case Single = 'single';
    case Double = 'double';
    case Triple = 'triple';
    case Quadrille = 'quadrille';

    case Default = 'default';
}
