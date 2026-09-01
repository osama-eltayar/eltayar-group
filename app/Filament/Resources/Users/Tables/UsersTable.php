<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\UserStatus;
use App\Filament\Resources\Users\UserResource;
use App\Filament\Support\RoleLabel;
use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Spatie\Permission\Models\Role;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordUrl(fn (User $record): string => UserResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('name')
                    ->label(__('user.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('user.email'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('user.status'))
                    ->badge()
                    ->sortable(),
                TextColumn::make('roles')
                    ->label(__('user.roles'))
                    ->badge()
                    ->state(fn (User $record): array => $record->roles
                        ->map(fn (Role $role): string => RoleLabel::for($role))
                        ->all()),
                IconColumn::make('has_salary')
                    ->label(__('user.has_salary'))
                    ->boolean(),
                TextColumn::make('invitationUrl')
                    ->label(__('user.invitation_link'))
                    ->state(fn (User $record): ?string => filled($record->invitation_token) ? __('user.copy_invitation_link') : null)
                    ->placeholder('—')
                    ->copyable(fn (User $record): bool => filled($record->invitation_token))
                    ->copyableState(fn (User $record): ?string => $record->invitationUrl())
                    ->copyMessage(__('user.invitation_link_copied')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('user.status'))
                    ->options(UserStatus::toOptions()),
                TernaryFilter::make('has_salary')
                    ->label(__('user.has_salary')),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                UserResource::sendInvitationWhatsAppAction(),
                UserResource::reinviteAction(),
                UserResource::banAction(),
                UserResource::unbanAction(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    UserResource::assignRolesBulkAction(),
                    UserResource::assignPermissionsBulkAction(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
