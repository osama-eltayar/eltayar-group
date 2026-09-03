<?php

namespace App\Filament\Resources\Tasks;

use App\Enums\TaskStatus;
use App\Filament\Resources\Tasks\Pages\CreateTask;
use App\Filament\Resources\Tasks\Pages\EditTask;
use App\Filament\Resources\Tasks\Pages\ListTasks;
use App\Filament\Resources\Tasks\Pages\ViewTask;
use App\Filament\Resources\Tasks\RelationManagers\AssignmentsRelationManager;
use App\Filament\Resources\Tasks\Schemas\TaskForm;
use App\Filament\Resources\Tasks\Schemas\TaskInfolist;
use App\Filament\Resources\Tasks\Tables\TasksTable;
use App\Models\Task;
use App\Services\Task\CancelTaskService;
use App\Services\Task\CompleteTaskService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('navigation.tasks');
    }

    public static function getModelLabel(): string
    {
        return __('task.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('task.label');
    }

    public static function completeTaskAction(): Action
    {
        return Action::make('completeTask')
            ->label(__('task.complete_task'))
            ->icon(Heroicon::CheckCircle)
            ->color('success')
            ->requiresConfirmation()
            ->authorize('complete')
            ->visible(fn (Task $record): bool => in_array($record->status, [TaskStatus::Draft, TaskStatus::Pending], true))
            ->action(fn (Task $record) => app(CompleteTaskService::class)->execute($record));
    }

    public static function cancelTaskAction(): Action
    {
        return Action::make('cancelTask')
            ->label(__('task.cancel_task'))
            ->icon(Heroicon::NoSymbol)
            ->color('danger')
            ->requiresConfirmation()
            ->authorize('cancel')
            ->visible(fn (Task $record): bool => in_array($record->status, [TaskStatus::Draft, TaskStatus::Pending], true))
            ->action(fn (Task $record) => app(CancelTaskService::class)->execute($record));
    }

    public static function form(Schema $schema): Schema
    {
        return TaskForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TaskInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TasksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AssignmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'view' => ViewTask::route('/{record}'),
            'edit' => EditTask::route('/{record}/edit'),
        ];
    }
}
