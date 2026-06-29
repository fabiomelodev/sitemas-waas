<?php

namespace App\Filament\Client\Widgets;

use App\Helpers\FormatCurrency;
use App\Models\SiteConfig;
use App\Models\Subscription;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AccountOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $userId = Auth::id();

        $activeCount = Subscription::query()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->count();

        $sitesCount = SiteConfig::query()->where('user_id', $userId)->count();

        $monthlyTotal = Subscription::query()
            ->where('subscriptions.user_id', $userId)
            ->where('subscriptions.status', 'active')
            ->join('plans', 'plans.id', '=', 'subscriptions.plan_id')
            ->sum('plans.price');

        $nextRenewal = Subscription::query()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->whereNotNull('expires_at')
            ->min('expires_at');

        return [
            Stat::make('Assinaturas ativas', $activeCount)
                ->description('Planos em vigência')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Seus sites', $sitesCount)
                ->description('Sites na sua conta')
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('primary'),

            Stat::make('Total mensal', FormatCurrency::getFormatCurrency($monthlyTotal))
                ->description('Soma das assinaturas ativas')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('gray'),

            Stat::make('Próxima renovação', $nextRenewal ? Carbon::parse($nextRenewal)->format('d/m/Y') : '—')
                ->description('Vencimento mais próximo')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('gray'),
        ];
    }
}
