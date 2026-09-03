<?php

namespace App\Filament\Resources\Bookings\Tables;

use App\Enums\BookingStatus;
use App\Enums\RoomType;
use App\Filament\Resources\Bookings\BookingResource;
use App\Models\Booking;
use App\Models\Haj;
use App\Models\Omra;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BookingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Booking $record): string => BookingResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('id')
                    ->label(__('booking.id'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('branch.name')
                    ->label(__('booking.branch'))
                    ->sortable(),
                TextColumn::make('client.name')
                    ->label(__('omra_client.client'))
                    ->searchable(),
                TextColumn::make('bookable.name')
                    ->label(__('booking.bookable'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('booking.status'))
                    ->badge(),
                TextColumn::make('room_type')
                    ->label(__('booking.room_type'))
                    ->badge(),
                TextColumn::make('number_of_clients')
                    ->label(__('booking.number_of_clients')),
                TextColumn::make('total_price')
                    ->label(__('booking.total_price'))
                    ->sortable(),
                TextColumn::make('discount_amount')
                    ->label(__('booking.discount_amount')),
                TextColumn::make('calculated_discount_amount')
                    ->label(__('booking.calculated_discount_amount'))
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('final_price')
                    ->label(__('booking.final_price'))
                    ->sortable(),
                TextColumn::make('paid')
                    ->label(__('booking.paid'))
                    ->sortable(),
                TextColumn::make('balance')
                    ->label(__('booking.balance'))
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('bookable_type')
                    ->label(__('booking.bookable_type'))
                    ->options([
                        Omra::class => __('omra.singular_label'),
                        Haj::class => __('haj.singular_label'),
                    ]),
                SelectFilter::make('status')
                    ->label(__('booking.status'))
                    ->options(BookingStatus::toOptions()),
                SelectFilter::make('room_type')
                    ->label(__('booking.room_type'))
                    ->options(RoomType::toOptions()),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                Action::make('applyDiscount')
                    ->label(__('booking.discount_amount'))
                    ->icon(Heroicon::Tag)
                    ->color('warning')
                    ->authorize('applyDiscount')
                    ->fillForm(fn (Booking $record): array => [
                        'discount_amount' => $record->discount_amount,
                    ])
                    ->schema([
                        TextInput::make('discount_amount')
                            ->label(__('booking.discount_amount'))
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                    ])
                    ->action(function (Booking $record, array $data): void {
                        $record->update(['discount_amount' => $data['discount_amount']]);
                    }),
                BookingResource::markBookingPendingAction(),
                BookingResource::markBookingCompletedAction(),
                BookingResource::cancelBookingAction(),
                BookingResource::refundBookingAction(),
            ]);
    }
}
