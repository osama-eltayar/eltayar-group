<?php

namespace App\Enums;

enum RoomType:string
{
    case Single = 'Single';
    case Double = 'Double';
    case Triple = 'Triple';
    case Quadrille = 'Quadrille';

    case Default = 'default';
}
