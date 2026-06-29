<?php

namespace App\Filament\Client\Widgets;

use App\Models\Subscription;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SubscriptionNotice extends Widget
{
    protected static ?int $sort = 0;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.client.widgets.subscription-notice';

    /**
     * Assinaturas canceladas/em atraso mas ainda dentro do período pago.
     */
    protected static function attentionQuery(): Builder
    {
        return Subscription::query()
            ->where('user_id', Auth::id())
            ->whereIn('status', ['canceled', 'past_due'])
            ->whereNotNull('expires_at')
            ->where('expires_at', '>=', now());
    }

    public static function canView(): bool
    {
        return self::attentionQuery()->exists();
    }

    protected function getViewData(): array
    {
        $notices = self::attentionQuery()
            ->with(['plan', 'template'])
            ->get()
            ->map(fn (Subscription $subscription): array => [
                'status' => $subscription->status,
                'days' => (int) ceil(now()->floatDiffInDays($subscription->expires_at)),
                'expiresAt' => $subscription->expires_at->format('d/m/Y'),
                'name' => $subscription->template?->name ?? $subscription->plan?->name,
            ]);

        return ['notices' => $notices];
    }
}
