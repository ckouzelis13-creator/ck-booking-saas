<?php

namespace App\Models;

use Filament\Models\Contracts\HasTenants; // <--- Σημαντικό Import
use Filament\Panel; // <--- Σημαντικό Import
use Illuminate\Database\Eloquent\Model; // <--- Σημαντικό Import
use Illuminate\Support\Collection; // <--- Σημαντικό Import
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements HasTenants // <--- Πρόσθεσε το "implements HasTenants"
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * 1. Επιστρέφει τα μαγαζιά στα οποία έχει πρόσβαση ο χρήστης
     */
    public function getTenants(Panel $panel): Collection
    {
        return $this->shops;
    }

    /**
     * 2. Ελέγχει αν ο χρήστης μπορεί να μπει σε ένα συγκεκριμένο μαγαζί
     */
    public function canAccessTenant(Model $tenant): bool
    {
        return $this->shops->contains($tenant);
    }

    public function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
}