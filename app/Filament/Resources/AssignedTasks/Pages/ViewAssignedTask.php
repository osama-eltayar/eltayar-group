<?php

namespace App\Filament\Resources\AssignedTasks\Pages;

use App\Filament\Resources\AssignedTasks\AssignedTaskResource;
use Filament\Resources\Pages\ViewRecord;

class ViewAssignedTask extends ViewRecord
{
    protected static string $resource = AssignedTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            AssignedTaskResource::markDoneAction(),
        ];
    }
}
