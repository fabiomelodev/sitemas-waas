<?php

namespace App\Filament\Resources\SiteConfigs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteConfigForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make()
                    ->columnSpan(9)
                    ->schema([
                        TextInput::make('company_name')
                            ->label('Nome da Empresa')
                            ->required(),
                        TextInput::make('domain')
                            ->label('Domínio'),
                        TextInput::make('whatsapp'),
                        TextInput::make('instagram'),
                        TextInput::make('facebook'),
                    ]),
                Section::make()
                    ->columnSpan(3)
                    ->schema([
                        FileUpload::make('brand')
                            ->label('Logo')
                            ->image(),
                        Select::make('subscription_id')
                            ->label('Asaas Assinatura ID')
                            ->relationship('subscription', 'asaas_subscription_id')
                            ->disabled(),
                        Select::make('user_id')
                            ->label('Cliente')
                            ->relationship('user', 'name')
                            ->disabled()
                            ->required(),
                        Toggle::make('is_finished')
                            ->label('Finalizado')
                            ->inline(false)
                            ->required(),
                        Toggle::make('status')
                            ->inline(false)
                            ->required(),
                    ]),
            ]);
    }
}
