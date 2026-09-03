<?php

namespace App\Filament\Resources\Hajs\RelationManagers;

use App\Enums\HajClientDependencyType;
use App\Enums\HajClientRelationType;
use App\Enums\PackageStatus;
use App\Filament\Resources\Clients\ClientResource;
use App\Filament\Resources\HajClients\HajClientResource;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Haj;
use App\Models\HajClient;
use Closure;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HajClientsRelationManager extends RelationManager
{
    protected static string $relationship = 'hajClients';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->label(__('haj_client.client'))
                    ->relationship('client', 'id')
                    ->getOptionLabelFromRecordUsing(fn (Client $record): string => $record->name)
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabled(fn (string $operation): bool => $operation === 'edit')
                    ->rules([
                        fn (): Closure => function (string $attribute, $value, Closure $fail): void {
                            $haj = $this->getOwnerRecord();

                            if ($haj->status === PackageStatus::Active && HajClient::clientHasAnotherActiveHaj((int) $value, $haj->id)) {
                                $fail(__('haj_client.client_already_in_active_haj'));
                            }
                        },
                    ]),
                Select::make('booking_id')
                    ->label(__('haj_client.booking'))
                    ->options(fn (): array => Booking::query()
                        ->where('bookable_type', Haj::class)
                        ->where('bookable_id', $this->getOwnerRecord()->id)
                        ->pluck('id', 'id')
                        ->all())
                    ->searchable()
                    ->preload()
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),
                Select::make('dependency_type')
                    ->label(__('haj_client.dependency_type'))
                    ->options(HajClientDependencyType::toOptions())
                    ->default(HajClientDependencyType::Independent->value)
                    ->live()
                    ->required()
                    ->rules([
                        fn (?HajClient $record): Closure => function (string $attribute, $value, Closure $fail) use ($record): void {
                            if ($value === HajClientDependencyType::Dependent->value && $record?->dependents()->exists()) {
                                $fail(__('haj_client.cannot_become_dependent_with_dependents'));
                            }
                        },
                    ]),
                Select::make('depends_on_haj_client_id')
                    ->label(__('haj_client.depends_on'))
                    ->options(fn (?HajClient $record): array => $this->getOwnerRecord()
                        ->hajClients()
                        ->where('dependency_type', HajClientDependencyType::Independent)
                        ->when($record, fn ($query, HajClient $record) => $query->whereKeyNot($record->id))
                        ->with('client')
                        ->get()
                        ->mapWithKeys(fn (HajClient $hajClient): array => [$hajClient->id => $hajClient->client->name])
                        ->all())
                    ->searchable()
                    ->visible(fn (Get $get): bool => $get('dependency_type') === HajClientDependencyType::Dependent->value)
                    ->required(fn (Get $get): bool => $get('dependency_type') === HajClientDependencyType::Dependent->value)
                    ->rules([
                        fn (): Closure => function (string $attribute, $value, Closure $fail): void {
                            $dependsOn = HajClient::find($value);

                            if ($dependsOn && $dependsOn->dependency_type !== HajClientDependencyType::Independent) {
                                $fail(__('haj_client.depends_on_must_be_independent'));
                            }
                        },
                    ]),
                Select::make('relation_type')
                    ->label(__('haj_client.relation_type'))
                    ->options(HajClientRelationType::toOptions())
                    ->visible(fn (Get $get): bool => $get('dependency_type') === HajClientDependencyType::Dependent->value)
                    ->required(fn (Get $get): bool => $get('dependency_type') === HajClientDependencyType::Dependent->value),
                RichEditor::make('notes')
                    ->label(__('haj_client.notes'))
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('client.name')
                    ->label(__('haj_client.client'))
                    ->url(fn (HajClient $record): ?string => $record->client ? ClientResource::getUrl('view', ['record' => $record->client]) : null)
                    ->searchable(),
                TextColumn::make('status')
                    ->label(__('haj_client.status'))
                    ->badge(),
                TextColumn::make('dependency_type')
                    ->label(__('haj_client.dependency_type'))
                    ->badge(),
                TextColumn::make('dependsOn.client.name')
                    ->label(__('haj_client.depends_on'))
                    ->url(fn (HajClient $record): ?string => $record->dependsOn ? HajClientResource::getUrl('view', ['record' => $record->dependsOn]) : null)
                    ->placeholder('—'),
                TextColumn::make('relation_type')
                    ->label(__('haj_client.relation_type'))
                    ->badge()
                    ->placeholder('—'),
                TextColumn::make('client.factory_number')
                    ->label(__('client.factory_number'))
                    ->placeholder('—'),
                TextColumn::make('client.passport_ended_at')
                    ->label(__('client.passport_ended_at'))
                    ->date()
                    ->badge()
                    ->color(fn (HajClient $record): ?string => $record->hasPassportBelowMinimum() ? 'danger' : 'gray')
                    ->icon(fn (HajClient $record): ?Heroicon => $record->hasPassportBelowMinimum() ? Heroicon::ExclamationTriangle : null)
                    ->tooltip(fn (HajClient $record): ?string => $record->hasPassportBelowMinimum() ? __('haj_client.passport_below_minimum') : null)
                    ->placeholder('—'),
                TextColumn::make('discount_amount')
                    ->label(__('haj_client.discount_amount')),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                Action::make('applyDiscount')
                    ->label(__('haj_client.discount_amount'))
                    ->icon(Heroicon::Tag)
                    ->color('warning')
                    ->authorize('applyDiscount')
                    ->fillForm(fn (HajClient $record): array => [
                        'discount_amount' => $record->discount_amount,
                    ])
                    ->schema([
                        TextInput::make('discount_amount')
                            ->label(__('haj_client.discount_amount'))
                            ->numeric()
                            ->minValue(0)
                            ->required(),
                    ])
                    ->action(function (HajClient $record, array $data): void {
                        $record->update(['discount_amount' => $data['discount_amount']]);
                    }),
                HajClientResource::markHajClientSuccessfulAction(),
                HajClientResource::markHajClientUnsuccessfulAction(),
                HajClientResource::markHajClientReserveAction(),
                HajClientResource::markHajClientWithdrawnAction(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
