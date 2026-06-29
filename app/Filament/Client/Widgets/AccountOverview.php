<?php

namespace App\Filament\Client\Widgets;

use App\Models\SiteConfig;
use App\Models\Subscription;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AccountOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $userId = Auth::id();

        $subscription = Subscription::query()
            ->where('user_id', $userId)
            ->with('plan')
            ->latest()
            ->first();

        $siteConfig = SiteConfig::query()
            ->where('user_id', $userId)
            ->latest()
            ->first();

        $statusLabels = [
            'active' => 'Ativa',
            'pending' => 'Pendente',
            'past_due' => 'Em atraso',
            'canceled' => 'Cancelada',
        ];

        $statusColors = [
            'active' => 'success',
            'pending' => 'warning',
            'past_due' => 'danger',
            'canceled' => 'danger',
        ];

        return [
            Stat::make('Plano', $subscription?->plan?->name ?? '—')
                ->description('Seu plano atual')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('primary'),

            Stat::make('Assinatura', $statusLabels[$subscription?->status] ?? '—')
                ->description('Situação da assinatura')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color($statusColors[$subscription?->status] ?? 'gray'),

            Stat::make('Próxima renovação', $subscription?->expires_at?->format('d/m/Y') ?? '—')
                ->description('Vencimento da assinatura')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('gray'),

            Stat::make('Seu site', $siteConfig?->stageLabel() ?? 'Recebido')
                ->description('Status de produção')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color($siteConfig?->stage === 'live' ? 'success' : 'info'),
        ];
    }
}
