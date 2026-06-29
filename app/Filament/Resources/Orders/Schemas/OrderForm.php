<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make()
                    ->columnSpan(9)
                    ->columns(2)
                    ->schema([
                        Select::make('user_id')
                            ->label('Nome')
                            ->relationship('user', 'name')
                            ->required()
                            ->columnSpanFull(),
                        Select::make('subscription_id')
                            ->label('Assinatura')
                            ->relationship('subscription', 'asaas_subscription_id')
                            ->required(),
                        TextInput::make('asaas_payment_id')
                            ->label('Asaas Pagamento ID'),
                    ]),
                Section::make()
                    ->columnSpan(3)
                    ->schema([

                        TextInput::make('amount')
                            ->label('Preço')
                            ->prefix('R$'),
                        Select::make('payment_method')
                            ->label('Meio de Pagamento')
                            ->options([
                                'CREDIT_CARD' => 'Cartão de Crédito',
                            ]),
                        Select::make('status')
                            ->options([
                                'completed' => 'Concluído',
                            ]),
                        DatePicker::make('paid_at')
                            ->label('Pago Em'),
                    ]),
            ]);
    }
}
