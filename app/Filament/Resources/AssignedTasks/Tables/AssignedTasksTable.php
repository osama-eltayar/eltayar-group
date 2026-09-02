<?php

namespace App\Filament\Resources\AssignedTasks\Tables;

use App\Enums\TaskStatus;
use App\Filament\Resources\AssignedTasks\AssignedTaskResource;
use App\Models\Task;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssignedTasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Task $record): string => AssignedTaskResource::getUrl('view', ['record' => $record]))
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['creator', 'assignments']))
            ->columns([
                TextColumn::make('title')
                    ->label(__('task.title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('task.status'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('my_status')
                    ->label(__('task.my_status'))
                    ->state(fn (Task $record): ?string => $record->assignments
                        ->firstWhere('user_id', auth()->id())
                        ?->status
                        ->getLabel())
                    ->badge(),
                TextColumn::make('creator.name')
                    ->label(__('task.creator'))
                    ->sortable(),
                TextColumn::make('finished_at')
                    ->label(__('task.finished_at'))
                    ->dateTime()
                    ->placeholder('—')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('task.status'))
                    ->options(TaskStatus::toOptions()),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                AssignedTaskResource::markDoneAction(),
            ])
            ->toolbarActions([]);
    }
}
