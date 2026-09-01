<?php

namespace App\Filament\Resources\Roles\Schemas;

use App\Filament\Support\PermissionOverview;
use App\Filament\Support\RoleLabel;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Spatie\Permission\Models\Role;

class RoleInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label(__('role.name'))
                    ->formatStateUsing(fn (Role $record): string => RoleLabel::for($record)),
                Section::make(__('permission.all_permissions'))
                    ->icon(Heroicon::ShieldCheck)
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull()
                    ->schema(fn (Role $record): array => PermissionOverview::sections(
                        $record->permissions->pluck('id')->all()
                    )),
            ]);
    }
}
