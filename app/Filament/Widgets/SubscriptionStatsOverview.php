<?php

namespace App\Filament\Widgets;

use App\Helpers\FormatCurrency;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SubscriptionStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // MRR: soma do preço dos planos de todas as assinaturas ativas.
        $mrr = Subscription::query()
            ->where('subscriptions.status', 'active')
            ->join('plans', 'plans.id', '=', 'subscriptions.plan_id')
            ->sum('plans.price');

        $activeSubscriptions = Subscription::query()->where('status', 'active')->count();

        $revenueThisMonth = Order::query()
            ->where('status', 'completed')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        $newCustomersThisMonth = User::query()
            ->where('is_admin', false)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return [
            Stat::make('Receita recorrente (MRR)', FormatCurrency::getFormatCurrency($mrr))
                ->description('Soma das assinaturas ativas')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Assinaturas ativas', $activeSubscriptions)
                ->description('Clientes pagantes no momento')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Receita no mês', FormatCurrency::getFormatCurrency($revenueThisMonth))
                ->description('Pagamentos confirmados em '.now()->translatedFormat('F'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Novos clientes no mês', $newCustomersThisMonth)
                ->description('Cadastros em '.now()->translatedFormat('F'))
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('info'),
        ];
    }
}
