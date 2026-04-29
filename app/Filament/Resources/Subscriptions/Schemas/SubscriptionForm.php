<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make()
                    ->columnSpan(9)
                    ->schema([
                        Select::make('user_id')
                            ->label('Cliente')
                            ->relationship('user', 'name')
                            ->disabled(),
                        Select::make('plan_id')
                            ->label('Plano')
                            ->relationship('plan', 'name'),
                    ]),
                Section::make()
                    ->columnSpan(3)
                    ->schema([
                        TextInput::make('asaas_subscription_id')
                            ->label('Assinatura ID'),
                        Select::make('status')
                            ->options(['active' => 'Ativo', 'inactive' => 'Inativo'])
                            ->default('active'),
                        DatePicker::make('expires_at')
                            ->label('Expira Em'),
                    ])
            ]);
    }
}
