<?php

namespace App\Filament\Resources\Tasks\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';

    public function isReadOnly(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->heading(__('task.assignees'))
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('task.assignee')),
                TextColumn::make('status')
                    ->label(__('task.assignee_status'))
                    ->badge(),
                TextColumn::make('comment')
                    ->label(__('task.comment'))
                    ->html()
                    ->wrap()
                    ->placeholder('—'),
                TextColumn::make('completed_at')
                    ->label(__('task.completed_at'))
                    ->dateTime()
                    ->placeholder('—'),
            ])
            ->headerActions([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
