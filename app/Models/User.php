<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'is_admin', 'password', 'password_set_at', 'asaas_customer_id', 'login_token', 'phone'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
            'is_admin' => 'boolean',
            'password_set_at' => 'datetime',
        ];
    }

    /**
     * Controle de acesso por painel:
     * - admin  (/admin)  → apenas administradores.
     * - client (/painel) → clientes (não administradores) dentro do período pago.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->is_admin === true,
            'client' => $this->is_admin === false && $this->hasPanelAccess(),
            default => false,
        };
    }

    /**
     * Cliente acessa o painel enquanto estiver dentro do período pago:
     * - assinatura ativa, OU
     * - cancelada/em atraso, mas com expires_at ainda no futuro.
     * (assinatura "pending", nunca paga, não dá acesso)
     */
    public function hasPanelAccess(): bool
    {
        return $this->subscriptions()
            ->where(function ($query) {
                $query->where('status', 'active')
                    ->orWhere(function ($withinPaidPeriod) {
                        $withinPaidPeriod->whereIn('status', ['canceled', 'past_due'])
                            ->whereNotNull('expires_at')
                            ->where('expires_at', '>=', now());
                    });
            })
            ->exists();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
