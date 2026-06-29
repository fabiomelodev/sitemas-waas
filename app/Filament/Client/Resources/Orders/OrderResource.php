<?php

namespace App\Filament\Client\Resources\Orders;

use App\Filament\Client\Resources\Orders\Pages\ListOrders;
use App\Helpers\FormatCurrency;
use App\Models\Order;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBanknotes;

    protected static ?string $label = 'Pagamento';

    protected static ?string $pluralLabel = 'Faturas';

    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('paid_at', 'desc')
            ->columns([
                TextColumn::make('paid_at')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->placeholder('—'),
                TextColumn::make('amount')
                    ->label('Valor')
                    ->formatStateUsing(fn ($state): string => FormatCurrency::getFormatCurrency($state)),
                TextColumn::make('payment_method')
                    ->label('Forma de pagamento')
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
                        'completed' => 'Pago',
                        'refunded' => 'Estornado',
                        default => $state ?? '—',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'completed' => 'success',
                        'refunded' => 'danger',
                        default => 'gray',
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
        ];
    }
}
