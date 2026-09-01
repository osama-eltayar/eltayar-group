<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Support\PermissionOverview;
use App\Filament\Support\RoleLabel;
use App\Models\User;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Spatie\Permission\Models\Role;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label(__('user.name')),
                TextEntry::make('email')
                    ->label(__('user.email')),
                TextEntry::make('status')
                    ->label(__('user.status'))
                    ->badge(),
                TextEntry::make('roles')
                    ->label(__('user.roles'))
                    ->badge()
                    ->state(fn (User $record): array => $record->roles
                        ->map(fn (Role $role): string => RoleLabel::for($role))
                        ->all()),
                TextEntry::make('invitationUrl')
                    ->label(__('user.invitation_link'))
                    ->state(fn (User $record): ?string => filled($record->invitation_token) ? __('user.copy_invitation_link') : null)
                    ->placeholder('—')
                    ->icon(fn (User $record): ?Heroicon => filled($record->invitation_token) ? Heroicon::Clipboard : null)
                    ->copyable(fn (User $record): bool => filled($record->invitation_token))
                    ->copyableState(fn (User $record): ?string => $record->invitationUrl())
                    ->copyMessage(__('user.invitation_link_copied'))
                    ->visible(fn (User $record): bool => $record->isPending()),
                TextEntry::make('created_at')
                    ->dateTime(),
                Section::make(__('permission.overview'))
                    ->icon(Heroicon::ShieldCheck)
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Tabs::make('permissionsOverview')
                            ->tabs(fn (User $record): array => PermissionOverview::tabs(
                                $record->getAllPermissions()->pluck('id')->all()
                            )),
                    ]),
            ]);
    }
}
