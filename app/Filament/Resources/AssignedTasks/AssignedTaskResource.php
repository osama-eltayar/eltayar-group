<?php

namespace App\Filament\Resources\AssignedTasks;

use App\Enums\TaskAssignmentStatus;
use App\Enums\TaskStatus;
use App\Filament\Resources\AssignedTasks\Pages\ListAssignedTasks;
use App\Filament\Resources\AssignedTasks\Pages\ViewAssignedTask;
use App\Filament\Resources\AssignedTasks\Schemas\AssignedTaskInfolist;
use App\Filament\Resources\AssignedTasks\Tables\AssignedTasksTable;
use App\Models\Task;
use App\Services\Task\MarkTaskAssignmentDoneService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AssignedTaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $slug = 'assigned-tasks';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?int $navigationSort = 2;

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
        return __('task.assigned_tasks_label');
    }

    public static function getNavigationLabel(): string
    {
        return __('task.assigned_tasks_label');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('assignees', fn (Builder $query): Builder => $query->where('users.id', auth()->id()))
            ->where('status', '!=', TaskStatus::Draft);
    }

    public static function canViewAny(): bool
    {
        return true;
    }

    public static function canView(Model $record): bool
    {
        return $record->assignees->contains('id', auth()->id());
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function markDoneAction(): Action
    {
        return Action::make('markDone')
            ->label(__('task.mark_done'))
            ->icon(Heroicon::CheckCircle)
            ->color('success')
            ->schema([
                RichEditor::make('comment')
                    ->label(__('task.comment')),
            ])
            ->requiresConfirmation()
            ->visible(function (Task $record): bool {
                $assignment = $record->assignments->firstWhere('user_id', auth()->id());

                return $record->status === TaskStatus::Pending
                    && $assignment?->status === TaskAssignmentStatus::Pending;
            })
            ->action(function (Task $record, array $data): void {
                $assignment = $record->assignments()->where('user_id', auth()->id())->firstOrFail();

                app(MarkTaskAssignmentDoneService::class)->execute($assignment, $data['comment'] ?? null);
            });
    }

    public static function infolist(Schema $schema): Schema
    {
        return AssignedTaskInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssignedTasksTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAssignedTasks::route('/'),
            'view' => ViewAssignedTask::route('/{record}'),
        ];
    }
}
