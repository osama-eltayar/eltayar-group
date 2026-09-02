<?php

namespace App\Filament\Resources\Tasks\Pages;

use App\Enums\TaskStatus;
use App\Filament\Resources\Tasks\TaskResource;
use App\Models\Task;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTask extends ViewRecord
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            TaskResource::completeTaskAction(),
            TaskResource::cancelTaskAction(),
            EditAction::make()
                ->visible(fn (Task $record): bool => in_array($record->status, [TaskStatus::Draft, TaskStatus::Pending], true)),
        ];
    }
}
