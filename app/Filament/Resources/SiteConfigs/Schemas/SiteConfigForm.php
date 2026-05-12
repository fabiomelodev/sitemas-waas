<?php

namespace App\Filament\Resources\SiteConfigs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SiteConfigForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('company_name')
                    ->required(),
                TextInput::make('domain'),
                TextInput::make('brand'),
                TextInput::make('whatsapp'),
                TextInput::make('instagram'),
                TextInput::make('facebook'),
                Toggle::make('status')
                    ->required(),
                Toggle::make('is_finished')
                    ->required(),
                TextInput::make('subscription_id')
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
