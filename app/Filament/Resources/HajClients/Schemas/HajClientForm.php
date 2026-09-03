<?php

namespace App\Filament\Resources\HajClients\Schemas;

use App\Enums\HajClientDependencyType;
use App\Enums\HajClientRelationType;
use App\Enums\PackageStatus;
use App\Filament\Resources\Clients\Schemas\ClientForm;
use App\Models\Booking;
use App\Models\Client;
use App\Models\Haj;
use App\Models\HajClient;
use Closure;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class HajClientForm
{
    public static function configure(Schema $schema): Schema
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
                    ->createOptionForm(ClientForm::quickCreateSchema())
                    ->disabled(fn (string $operation): bool => $operation === 'edit')
                    ->rules([
                        fn (Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get): void {
                            $haj = Haj::find($get('haj_id'));

                            if ($haj?->status === PackageStatus::Active && HajClient::clientHasAnotherActiveHaj((int) $value, $haj->id)) {
                                $fail(__('haj_client.client_already_in_active_haj'));
                            }
                        },
                    ]),
                Select::make('haj_id')
                    ->label(__('haj_client.haj'))
                    ->relationship('haj', 'name')
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('booking_id', null))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->disabled(fn (string $operation): bool => $operation === 'edit'),
                Select::make('booking_id')
                    ->label(__('haj_client.booking'))
                    ->options(fn (Get $get): array => Booking::query()
                        ->where('bookable_type', Haj::class)
                        ->where('bookable_id', $get('haj_id'))
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
                    ->required(),
                Select::make('depends_on_haj_client_id')
                    ->label(__('haj_client.depends_on'))
                    ->options(fn (Get $get, ?HajClient $record): array => HajClient::query()
                        ->where('haj_id', $get('haj_id'))
                        ->when($record, fn ($query, HajClient $record) => $query->whereKeyNot($record->id))
                        ->with('client')
                        ->get()
                        ->mapWithKeys(fn (HajClient $hajClient): array => [$hajClient->id => $hajClient->client->name])
                        ->all())
                    ->searchable()
                    ->visible(fn (Get $get): bool => $get('dependency_type') === HajClientDependencyType::Dependent->value)
                    ->required(fn (Get $get): bool => $get('dependency_type') === HajClientDependencyType::Dependent->value),
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
}
