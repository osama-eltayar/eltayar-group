<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum TripStatus: string implements HasLabel
{
    use EnumOptions;
    //
    case DRAFT = 'draft';
    case Active = 'active';

    public function getLabel(): string
    {
        return __("enums.trip_status.{$this->value}");
    }
}
