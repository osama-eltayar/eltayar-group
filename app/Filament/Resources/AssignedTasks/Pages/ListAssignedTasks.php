<?php

namespace App\Filament\Resources\AssignedTasks\Pages;

use App\Filament\Resources\AssignedTasks\AssignedTaskResource;
use Filament\Resources\Pages\ListRecords;

class ListAssignedTasks extends ListRecords
{
    protected static string $resource = AssignedTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
