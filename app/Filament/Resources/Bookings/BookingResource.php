<?php

namespace App\Filament\Resources\Bookings;

use App\Enums\BookingStatus;
use App\Enums\PaymentMethod;
use App\Filament\Resources\Bookings\Pages\CreateBooking;
use App\Filament\Resources\Bookings\Pages\ListBookings;
use App\Filament\Resources\Bookings\Pages\ViewBooking;
use App\Filament\Resources\Bookings\RelationManagers\HajClientsRelationManager;
use App\Filament\Resources\Bookings\RelationManagers\OmraClientsRelationManager;
use App\Filament\Resources\Bookings\RelationManagers\TransactionsRelationManager;
use App\Filament\Resources\Bookings\Schemas\BookingForm;
use App\Filament\Resources\Bookings\Tables\BookingsTable;
use App\Models\Booking;
use App\Services\Booking\CancelBookingService;
use App\Services\Booking\MarkBookingCompletedService;
use App\Services\Booking\MarkBookingPendingService;
use App\Services\Booking\RefundBookingService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function getModelLabel(): string
    {
        return __('booking.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('booking.label');
    }

    public static function markBookingPendingAction(): Action
    {
        return Action::make('markPending')
            ->label(__('booking.mark_pending'))
            ->icon(Heroicon::Clock)
            ->color('info')
            ->requiresConfirmation()
            ->authorize('markPending')
            ->visible(fn (Booking $record): bool => $record->status === BookingStatus::Draft)
            ->action(fn (Booking $record) => app(MarkBookingPendingService::class)->execute($record));
    }

    public static function markBookingCompletedAction(): Action
    {
        return Action::make('markCompleted')
            ->label(__('booking.mark_completed'))
            ->icon(Heroicon::CheckCircle)
            ->color('success')
            ->requiresConfirmation()
            ->authorize('markCompleted')
            ->visible(fn (Booking $record): bool => $record->status === BookingStatus::Draft)
            ->action(fn (Booking $record) => app(MarkBookingCompletedService::class)->execute($record));
    }

    public static function cancelBookingAction(): Action
    {
        return Action::make('cancelBooking')
            ->label(__('booking.cancel'))
            ->icon(Heroicon::NoSymbol)
            ->color('danger')
            ->requiresConfirmation()
            ->authorize('cancel')
            ->visible(fn (Booking $record): bool => ! in_array($record->status, [BookingStatus::Cancelled, BookingStatus::Refunded], true))
            ->action(fn (Booking $record) => app(CancelBookingService::class)->execute($record));
    }

    public static function refundBookingAction(): Action
    {
        return Action::make('refundBooking')
            ->label(__('booking.refund'))
            ->icon(Heroicon::ArrowUturnLeft)
            ->color('warning')
            ->authorize('refund')
            ->visible(fn (Booking $record): bool => $record->status === BookingStatus::Cancelled)
            ->fillForm(fn (Booking $record): array => ['amount' => $record->paid])
            ->schema([
                Select::make('payment_method')
                    ->label(__('transaction.payment_method'))
                    ->options([
                        PaymentMethod::CASH->value => PaymentMethod::CASH->getLabel(),
                        PaymentMethod::BANK->value => PaymentMethod::BANK->getLabel(),
                    ])
                    ->required(),
                TextInput::make('amount')
                    ->label(__('transaction.amount'))
                    ->numeric()
                    ->minValue(0)
                    ->required(),
            ])
            ->action(function (Booking $record, array $data): void {
                app(RefundBookingService::class)->execute(
                    $record,
                    PaymentMethod::from($data['payment_method']),
                    (int) $data['amount'],
                );
            });
    }

    public static function form(Schema $schema): Schema
    {
        return BookingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BookingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            OmraClientsRelationManager::class,
            HajClientsRelationManager::class,
            TransactionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBookings::route('/'),
            'create' => CreateBooking::route('/create'),
            'view' => ViewBooking::route('/{record}'),
        ];
    }
}
