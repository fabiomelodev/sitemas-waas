<?php

namespace App\Filament\Client\Widgets;

use App\Models\Subscription;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class SubscriptionNotice extends Widget
{
    protected static ?int $sort = 0;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.client.widgets.subscription-notice';

    protected static function currentSubscription(): ?Subscription
    {
        return Subscription::query()
            ->where('user_id', Auth::id())
            ->latest()
            ->first();
    }

    /**
     * Só exibe quando a assinatura está cancelada/em atraso mas o acesso ainda
     * é válido (dentro do período pago).
     */
    public static function canView(): bool
    {
        $subscription = self::currentSubscription();

        return $subscription
            && $subscription->expires_at
            && in_array($subscription->status, ['canceled', 'past_due'])
            && $subscription->expires_at->isFuture();
    }

    protected function getViewData(): array
    {
        $subscription = self::currentSubscription();

        return [
            'status' => $subscription?->status,
            'days' => $subscription?->expires_at ? (int) ceil(now()->floatDiffInDays($subscription->expires_at)) : 0,
            'expiresAt' => $subscription?->expires_at?->format('d/m/Y'),
        ];
    }
}
