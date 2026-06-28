<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class RevenueChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Receita dos últimos 6 meses';

    protected function getData(): array
    {
        $labels = [];
        $values = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);

            $total = Order::query()
                ->where('status', 'completed')
                ->whereMonth('paid_at', $month->month)
                ->whereYear('paid_at', $month->year)
                ->sum('amount');

            $labels[] = ucfirst($month->translatedFormat('M/y'));
            $values[] = (float) $total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Receita (R$)',
                    'data' => $values,
                    'backgroundColor' => 'rgba(37, 99, 235, 0.2)',
                    'borderColor' => 'rgb(37, 99, 235)',
                    'fill' => true,
                    'tension' => 0.3,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
