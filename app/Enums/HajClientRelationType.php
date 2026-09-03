<?php

namespace App\Enums;

use App\Traits\EnumOptions;
use Filament\Support\Contracts\HasLabel;

enum HajClientRelationType: string implements HasLabel
{
    use EnumOptions;
    case Husband = 'husband';
    case Wife = 'wife';
    case Father = 'father';
    case Mother = 'mother';
    case Son = 'son';
    case Daughter = 'daughter';
    case Brother = 'brother';
    case Sister = 'sister';
    case Grandfather = 'grandfather';
    case Grandmother = 'grandmother';
    case PaternalUncle = 'paternal_uncle';
    case PaternalAunt = 'paternal_aunt';
    case MaternalUncle = 'maternal_uncle';
    case MaternalAunt = 'maternal_aunt';
    case Relative = 'relative';
    case Friend = 'friend';
    case Other = 'other';
}
