<?php

namespace App\Filament\Widgets;

use App\Helpers\FormatCurrency;
use App\Models\Order;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestOrders extends TableWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Pagamentos recentes')
            ->query(Order::query()->with('user')->latest('paid_at'))
            ->columns([
                TextColumn::make('user.name')
                    ->label('Cliente')
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Valor')
                    ->formatStateUsing(fn ($state): string => FormatCurrency::getFormatCurrency($state)),
                TextColumn::make('payment_method')
                    ->label('Forma')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'CREDIT_CARD' => 'Cartão',
                        'PIX' => 'Pix',
                        'BOLETO' => 'Boleto',
                        default => $state ?? '—',
                    }),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'completed' => 'Concluído',
                        'refunded' => 'Estornado',
                        default => $state ?? '—',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'completed' => 'success',
                        'refunded' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('paid_at')
                    ->label('Pago em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->paginated([5, 10]);
    }
}
