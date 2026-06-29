<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Helpers\FormatCurrency;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make()
                    ->columnSpan(9)
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Cliente'),
                        TextEntry::make('subscription.plan.name')
                            ->label('Plano'),
                        TextEntry::make('asaas_payment_id')
                            ->label('Asaas Pagamento ID')
                            ->placeholder('-'),
                    ]),
                Section::make()
                    ->columnSpan(3)
                    ->schema([
                        TextEntry::make('amount')
                            ->label('Preço')
                            ->formatStateUsing(fn (string $state): string => FormatCurrency::getFormatCurrency($state))
                            ->size(TextSize::Large)
                            ->weight(FontWeight::Bold),
                        TextEntry::make('payment_method')
                            ->label('Meio de Pagamento')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'CREDIT_CARD' => 'Crédito',
                                default => $state
                            }),
                        TextEntry::make('status')
                            ->placeholder('-')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'completed' => 'Concluído',
                                default => $state
                            }),
                        TextEntry::make('paid_at')
                            ->label('Pago Em')
                            ->date('d/m/Y')
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
