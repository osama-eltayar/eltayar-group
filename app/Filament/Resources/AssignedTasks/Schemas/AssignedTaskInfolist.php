<?php

namespace App\Filament\Resources\AssignedTasks\Schemas;

use App\Models\Task;
use App\Models\TaskAssignment;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AssignedTaskInfolist
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
                TextEntry::make('my_status')
                    ->label(__('task.my_status'))
                    ->state(fn (Task $record): ?string => self::currentAssignment($record)?->status->getLabel())
                    ->badge(),
                TextEntry::make('my_comment')
                    ->label(__('task.comment'))
                    ->state(fn (Task $record): ?string => self::currentAssignment($record)?->comment)
                    ->html()
                    ->columnSpanFull()
                    ->placeholder('—'),
                TextEntry::make('description')
                    ->label(__('task.description'))
                    ->html()
                    ->columnSpanFull()
                    ->placeholder('—'),
            ])
            ->columns(2);
    }

    private static function currentAssignment(Task $record): ?TaskAssignment
    {
        return $record->assignments->firstWhere('user_id', auth()->id());
    }
}
