<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Models\Task;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class TaskInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title')
                    ->label(__('task.title')),
                TextEntry::make('status')
                    ->label(__('task.status'))
                    ->badge(),
                TextEntry::make('creator.name')
                    ->label(__('task.creator')),
                TextEntry::make('assignees.name')
                    ->label(__('task.assignees'))
                    ->badge(),
                TextEntry::make('completion_mode')
                    ->label(__('task.completion_mode'))
                    ->visible(fn (Task $record): bool => $record->hasMultipleAssignees()),
                TextEntry::make('finished_at')
                    ->label(__('task.finished_at'))
                    ->dateTime()
                    ->placeholder('—'),
                TextEntry::make('created_at')
                    ->label(__('task.created_at'))
                    ->dateTime(),
                TextEntry::make('description')
                    ->label(__('task.description'))
                    ->html()
                    ->columnSpanFull()
                    ->placeholder('—'),
            ])
            ->columns(2);
    }
}
