<?php

namespace App\Filament\Resources\Bookings\Schemas;

use App\Enums\BookingStatus;
use App\Enums\RoomType;
use App\Models\Client;
use App\Models\Haj;
use App\Models\Omra;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class BookingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('branch_id')
                    ->label(__('booking.branch'))
                    ->relationship('branch', 'name')
                    ->default(fn (): ?int => session('branch_id'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('client_id')
                    ->label(__('omra_client.client'))
                    ->relationship('client', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Client $record): string => $record->name)
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('status')
                    ->label(__('booking.status'))
                    ->options(BookingStatus::toOptions())
                    ->default(BookingStatus::Draft->value)
                    ->disabled(fn (string $operation): bool => $operation === 'edit')
                    ->required(),
                Select::make('bookable_type')
                    ->label(__('booking.bookable_type'))
                    ->options([
                        Omra::class => __('omra.singular_label'),
                        Haj::class => __('haj.singular_label'),
                    ])
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('bookable_id', null))
                    ->required(),
                Select::make('bookable_id')
                    ->label(__('booking.bookable'))
                    ->options(fn (Get $get): array => match ($get('bookable_type')) {
                        Omra::class => Omra::query()->pluck('name', 'id')->all(),
                        Haj::class => Haj::query()->pluck('name', 'id')->all(),
                        default => [],
                    })
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $state): void {
                        if ($get('bookable_type') === Haj::class && $state) {
                            $set('price', Haj::query()->find($state)?->deposit_price);
                        }
                    })
                    ->required(),
                Select::make('room_type')
                    ->label(__('booking.room_type'))
                    ->options(RoomType::toOptions())
                    ->default(RoomType::Default->value)
                    ->disabled(fn (Get $get): bool => $get('bookable_type') === Haj::class)
                    ->required(fn (Get $get): bool => $get('bookable_type') !== Haj::class),
                TextInput::make('price')
                    ->label(__('booking.price'))
                    ->helperText(__('booking.price_per_client_hint'))
                    ->numeric()
                    ->minValue(0)
                    ->disabled(fn (Get $get): bool => $get('bookable_type') === Haj::class)
                    ->saved()
                    ->required(),
                TextInput::make('number_of_clients')
                    ->label(__('booking.number_of_clients'))
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required(),
                RichEditor::make('notes')
                    ->label(__('booking.notes'))
                    ->columnSpanFull(),
                Section::make(__('booking.singular_label'))
                    ->columns(3)
                    ->hiddenOn('create')
                    ->schema([
                        TextInput::make('total_price')
                            ->label(__('booking.total_price'))
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('discount_amount')
                            ->label(__('booking.discount_amount'))
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('calculated_discount_amount')
                            ->label(__('booking.calculated_discount_amount'))
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('final_price')
                            ->label(__('booking.final_price'))
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('paid')
                            ->label(__('booking.paid'))
                            ->helperText(__('booking.paid_hint'))
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('balance')
                            ->label(__('booking.balance'))
                            ->disabled()
                            ->dehydrated(false),
                    ]),
            ])
            ->columns(2);
    }
}
