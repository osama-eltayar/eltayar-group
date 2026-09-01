<?php

namespace App\Filament\Resources\Salaries;

use App\Filament\Resources\Salaries\Pages\CreateSalary;
use App\Filament\Resources\Salaries\Pages\EditSalary;
use App\Filament\Resources\Salaries\Pages\ListSalaries;
use App\Filament\Resources\Salaries\Pages\ViewSalary;
use App\Filament\Resources\Salaries\RelationManagers\SalaryLogsRelationManager;
use App\Filament\Resources\Salaries\Schemas\SalaryForm;
use App\Filament\Resources\Salaries\Schemas\SalaryInfolist;
use App\Filament\Resources\Salaries\Tables\SalariesTable;
use App\Models\Salary;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SalaryResource extends Resource
{
    protected static ?string $model = Salary::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getModelLabel(): string
    {
        return __('salary.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('salary.label');
    }

    public static function endSalaryAction(): Action
    {
        return Action::make('endSalary')
            ->label(__('salary.end_salary'))
            ->icon(Heroicon::NoSymbol)
            ->color('danger')
            ->requiresConfirmation()
            ->authorize('endSalary')
            ->visible(fn (Salary $record): bool => $record->ended_at === null)
            ->action(fn (Salary $record) => $record->update(['ended_at' => now()]));
    }

    public static function form(Schema $schema): Schema
    {
        return SalaryForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SalaryInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SalariesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            SalaryLogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSalaries::route('/'),
            'create' => CreateSalary::route('/create'),
            'view' => ViewSalary::route('/{record}'),
            'edit' => EditSalary::route('/{record}/edit'),
        ];
    }
}
