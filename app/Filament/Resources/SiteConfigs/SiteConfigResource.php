<?php

namespace App\Filament\Resources\SiteConfigs;

use App\Filament\Resources\SiteConfigs\Pages\CreateSiteConfig;
use App\Filament\Resources\SiteConfigs\Pages\EditSiteConfig;
use App\Filament\Resources\SiteConfigs\Pages\ListSiteConfigs;
use App\Filament\Resources\SiteConfigs\Schemas\SiteConfigForm;
use App\Filament\Resources\SiteConfigs\Tables\SiteConfigsTable;
use App\Models\SiteConfig;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SiteConfigResource extends Resource
{
    protected static ?string $model = SiteConfig::class;

    // protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static ?string $recordTitleAttribute = 'SiteConfig';

    protected static ?string $label = 'Site';

    protected static ?string $pluralLabel = 'Sites';

    protected static string|UnitEnum|null $navigationGroup = 'Sites';

    public static function form(Schema $schema): Schema
    {
        return SiteConfigForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SiteConfigsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSiteConfigs::route('/'),
            'create' => CreateSiteConfig::route('/create'),
            'edit' => EditSiteConfig::route('/{record}/edit'),
        ];
    }
}
