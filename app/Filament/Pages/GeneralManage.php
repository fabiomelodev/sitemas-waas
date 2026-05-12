<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use BackedEnum;
use Dom\Text;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use General;
use UnitEnum;

class GeneralManage extends SettingsPage
{
    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string $settings = GeneralSettings::class;

    protected static ?string $title = 'Informações Gerais';

    protected static ?string $navigationLabel = 'Informações Gerais';

    protected static string|UnitEnum|null $navigationGroup = 'Informações Gerais';

    protected static ?int $navigationSort = 2;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dados')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('whatsapp'),
                        TextInput::make('instagram'),
                        TextInput::make('facebook'),
                    ])
            ]);
    }
}
