<?php

namespace App\Filament\Resources\Permissions\Schemas;

use App\Filament\Support\PermissionLabel;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;

class PermissionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label(__('permission.name'))
                    ->formatStateUsing(fn (Permission $record): string => PermissionLabel::for($record)),
                TextEntry::make('group')
                    ->label(__('permission.group'))
                    ->formatStateUsing(fn (string $state): string => PermissionLabel::group($state))
                    ->badge(),
                TextEntry::make('roles.name')
                    ->label(__('permission.roles'))
                    ->badge(),
            ]);
    }
}
