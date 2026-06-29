<?php

namespace App\Filament\Resources\SiteConfigs\Pages;

use App\Filament\Resources\SiteConfigs\SiteConfigResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListSiteConfigs extends ListRecords
{
    protected static string $resource = SiteConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make()
                ->label('Todos'),
            'active' => Tab::make()
                ->label('Finalizados')
                ->modifyQueryUsing(fn (Builder $query) => $query->isFinished()),
            'inactive' => Tab::make()
                ->label('Não Finalizados')
                ->modifyQueryUsing(fn (Builder $query) => $query->isNotFinished()),
        ];
    }
}
