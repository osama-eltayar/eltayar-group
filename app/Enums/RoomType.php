<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum RoomType: string
{
    use EnumOptions;
//    case Single = 'single';
//    case Double = 'double';
//    case Triple = 'triple';
//    case Quadrille = 'quadrille';

    case Default = 'default';
}
