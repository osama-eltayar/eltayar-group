<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleEnum;
use App\Enums\UserStatus;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'invitation_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'invitation_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(RoleEnum::SuperAdmin);
    }

    public function isPending(): bool
    {
        return $this->status === UserStatus::Pending;
    }

    public function isActive(): bool
    {
        return $this->status === UserStatus::Active;
    }

    public function isBanned(): bool
    {
        return $this->status === UserStatus::Banned;
    }

    public function invitationUrl(): ?string
    {
        if (blank($this->invitation_token)) {
            return null;
        }

        return URL::to("/invitation/{$this->invitation_token}");
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return ! $this->isBanned();
    }

    public function getAuthPassword(): string
    {
        return $this->password ?? Hash::make(Str::random(40));
    }
}
