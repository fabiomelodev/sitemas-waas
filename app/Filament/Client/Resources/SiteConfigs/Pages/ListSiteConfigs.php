<?php

namespace App\Filament\Client\Resources\SiteConfigs\Pages;

use App\Filament\Client\Resources\SiteConfigs\SiteConfigResource;
use Filament\Resources\Pages\ListRecords;

class ListSiteConfigs extends ListRecords
{
    protected static string $resource = SiteConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // O site é criado automaticamente após o pagamento; o cliente não cria.
        ];
    }
}
