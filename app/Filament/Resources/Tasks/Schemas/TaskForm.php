<?php

namespace App\Filament\Resources\Tasks\Schemas;

use App\Enums\TaskCompletionMode;
use App\Enums\TaskStatus;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label(__('task.title'))
                    ->required()
                    ->maxLength(255),
                Select::make('status')
                    ->label(__('task.status'))
                    ->options([
                        TaskStatus::Draft->value => TaskStatus::Draft->getLabel(),
                        TaskStatus::Pending->value => TaskStatus::Pending->getLabel(),
                    ])
                    ->default(TaskStatus::Draft->value)
                    ->required(),
                Select::make('assignees')
                    ->label(__('task.assignees'))
                    ->relationship('assignees', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->live()
                    ->required()
                    ->columnSpanFull(),
                Select::make('completion_mode')
                    ->label(__('task.completion_mode'))
                    ->helperText(__('task.completion_mode_hint'))
                    ->options(TaskCompletionMode::toOptions())
                    ->default(TaskCompletionMode::RequireAny->value)
                    ->visible(fn (Get $get): bool => count($get('assignees') ?? []) > 1)
                    ->required(fn (Get $get): bool => count($get('assignees') ?? []) > 1)
                    ->columnSpanFull(),
                RichEditor::make('description')
                    ->label(__('task.description'))
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }
}
