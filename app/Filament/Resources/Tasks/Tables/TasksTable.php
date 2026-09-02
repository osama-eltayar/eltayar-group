<?php

namespace App\Filament\Resources\Tasks\Tables;

use App\Enums\TaskStatus;
use App\Filament\Resources\Tasks\TaskResource;
use App\Models\Task;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Task $record): string => TaskResource::getUrl('view', ['record' => $record]))
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['creator', 'assignees']))
            ->columns([
                TextColumn::make('title')
                    ->label(__('task.title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('task.status'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('creator.name')
                    ->label(__('task.creator'))
                    ->sortable(),
                TextColumn::make('assignees.name')
                    ->label(__('task.assignees'))
                    ->badge(),
                TextColumn::make('finished_at')
                    ->label(__('task.finished_at'))
                    ->dateTime()
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('task.created_at'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('task.status'))
                    ->options(TaskStatus::toOptions()),
                SelectFilter::make('created_by')
                    ->label(__('task.creator'))
                    ->relationship('creator', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('assignees')
                    ->label(__('task.assignees'))
                    ->relationship('assignees', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                TaskResource::completeTaskAction(),
                TaskResource::cancelTaskAction(),
                EditAction::make()
                    ->visible(fn (Task $record): bool => in_array($record->status, [TaskStatus::Draft, TaskStatus::Pending], true)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
