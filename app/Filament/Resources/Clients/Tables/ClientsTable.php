<?php

namespace App\Filament\Resources\Clients\Tables;

use App\Enums\ClientStatus;
use App\Filament\Resources\Clients\ClientResource;
use App\Models\Client;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Client $record): string => ClientResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('id')
                    ->sortable(),
                TextColumn::make('name_en')
                    ->label(__('client.name_en'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name_ar')
                    ->label(__('client.name_ar'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('national_number')
                    ->label(__('client.national_number'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('passport_number')
                    ->label(__('client.passport_number'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('date_of_birth')
                    ->label(__('client.date_of_birth'))
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label(__('client.status'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('client.status'))
                    ->options(ClientStatus::toOptions()),
                SelectFilter::make('trips')
                    ->label(__('client.trips'))
                    ->relationship('trips', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload(),
                Filter::make('national_number')
                    ->label(__('client.national_number'))
                    ->schema([
                        TextInput::make('national_number'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['national_number'] ?? null,
                        fn (Builder $query, string $value): Builder => $query->where('national_number', 'like', "%{$value}%"),
                    )),
                Filter::make('passport_number')
                    ->label(__('client.passport_number'))
                    ->schema([
                        TextInput::make('passport_number'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['passport_number'] ?? null,
                        fn (Builder $query, string $value): Builder => $query->where('passport_number', 'like', "%{$value}%"),
                    )),
                Filter::make('date_of_birth')
                    ->label(__('client.date_of_birth'))
                    ->schema([
                        DatePicker::make('born_from')
                            ->label(__('client.born_from')),
                        DatePicker::make('born_until')
                            ->label(__('client.born_until')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['born_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('date_of_birth', '>=', $date),
                            )
                            ->when(
                                $data['born_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('date_of_birth', '<=', $date),
                            );
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
