<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum RoomType: string
{
    use EnumOptions;
    case Single = 'Single';
    case Double = 'Double';
    case Triple = 'Triple';
    case Quadrille = 'Quadrille';

    case Default = 'default';
}
