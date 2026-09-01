<?php

namespace App\Filament\Resources\Users;

use App\Enums\UserStatus;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ManagePermissions;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Schemas\UserInfolist;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Filament\Support\PermissionLabel;
use App\Filament\Support\RoleLabel;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getModelLabel(): string
    {
        return __('user.singular_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('user.label');
    }

    public static function sendInvitationWhatsAppAction(): Action
    {
        return Action::make('sendInvitationWhatsApp')
            ->label(__('user.send_via_whatsapp'))
            ->icon(Heroicon::ChatBubbleLeftRight)
            ->color('success')
            ->visible(fn (User $record): bool => filled($record->invitation_token))
            ->url(fn (User $record): string => 'https://wa.me/?text='.urlencode(
                __('user.invitation_whatsapp_message', [
                    'app' => config('app.name'),
                    'link' => $record->invitationUrl(),
                ])
            ))
            ->openUrlInNewTab();
    }

    public static function banAction(): Action
    {
        return Action::make('ban')
            ->label(__('user.ban'))
            ->icon(Heroicon::NoSymbol)
            ->color('danger')
            ->requiresConfirmation()
            ->visible(fn (User $record): bool => ! $record->isBanned())
            ->action(fn (User $record) => $record->update(['status' => UserStatus::Banned]));
    }

    public static function unbanAction(): Action
    {
        return Action::make('unban')
            ->label(__('user.unban'))
            ->icon(Heroicon::CheckCircle)
            ->color('success')
            ->requiresConfirmation()
            ->visible(fn (User $record): bool => $record->isBanned())
            ->action(fn (User $record) => $record->update([
                'status' => filled($record->password) ? UserStatus::Active : UserStatus::Pending,
            ]));
    }

    public static function deleteInvitationLinkAction(): Action
    {
        return Action::make('deleteInvitationLink')
            ->label(__('user.delete_invitation_link'))
            ->icon(Heroicon::Trash)
            ->color('danger')
            ->requiresConfirmation()
            ->visible(fn (User $record): bool => filled($record->invitation_token))
            ->action(fn (User $record) => $record->update(['invitation_token' => null]));
    }

    public static function reinviteAction(): Action
    {
        return Action::make('reinvite')
            ->label(__('user.reinvite'))
            ->icon(Heroicon::ArrowPath)
            ->color('warning')
            ->requiresConfirmation()
            ->visible(fn (User $record): bool => $record->isPending() && blank($record->invitation_token))
            ->action(fn (User $record) => $record->update(['invitation_token' => Str::random(48)]));
    }

    public static function changePasswordAction(): Action
    {
        return Action::make('changePassword')
            ->label(__('user.change_password'))
            ->icon(Heroicon::Key)
            ->schema([
                TextInput::make('current_password')
                    ->label(__('user.current_password'))
                    ->password()
                    ->revealable(filament()->arePasswordsRevealable())
                    ->required()
                    ->currentPassword(guard: Filament::getAuthGuard()),
                TextInput::make('password')
                    ->label(__('user.new_password'))
                    ->password()
                    ->revealable(filament()->arePasswordsRevealable())
                    ->required()
                    ->rule(Password::default())
                    ->same('passwordConfirmation'),
                TextInput::make('passwordConfirmation')
                    ->label(__('user.confirm_password'))
                    ->password()
                    ->revealable(filament()->arePasswordsRevealable())
                    ->required()
                    ->dehydrated(false),
            ])
            ->action(function (array $data): void {
                Auth::user()->update(['password' => $data['password']]);

                Notification::make()
                    ->success()
                    ->title(__('user.password_updated'))
                    ->send();
            })
            ->sort(0);
    }

    public static function assignRolesBulkAction(): BulkAction
    {
        return BulkAction::make('assignRoles')
            ->label(__('user.assign_roles'))
            ->icon(Heroicon::UserGroup)
            ->color('gray')
            ->requiresConfirmation()
            ->authorizeIndividualRecords('update')
            ->schema([
                Select::make('roles')
                    ->label(__('user.roles'))
                    ->options(fn (): array => Role::query()->get()
                        ->mapWithKeys(fn (Role $role): array => [$role->id => RoleLabel::for($role)])
                        ->all())
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->required(),
            ])
            ->action(function (Collection $records, array $data): void {
                $records->each(fn (User $user) => $user->assignRole($data['roles']));
            });
    }

    public static function assignPermissionsBulkAction(): BulkAction
    {
        return BulkAction::make('assignPermissions')
            ->label(__('user.assign_permissions'))
            ->icon(Heroicon::Key)
            ->color('gray')
            ->requiresConfirmation()
            ->authorizeIndividualRecords('update')
            ->schema([
                Select::make('permissions')
                    ->label(__('user.permissions'))
                    ->options(fn (): array => Permission::query()->get()
                        ->mapWithKeys(fn (Permission $permission): array => [$permission->id => PermissionLabel::for($permission)])
                        ->all())
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->required(),
            ])
            ->action(function (Collection $records, array $data): void {
                $records->each(fn (User $user) => $user->givePermissionTo($data['permissions']));
            });
    }

    public static function managePermissionsAction(): Action
    {
        return Action::make('managePermissions')
            ->label(__('user.manage_permissions'))
            ->icon(Heroicon::ShieldCheck)
            ->color('gray')
            ->authorize('update')
            ->url(fn (User $record): string => static::getUrl('permissions', ['record' => $record]));
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
            'permissions' => ManagePermissions::route('/{record}/permissions'),
        ];
    }
}
