<?php

namespace App\Filament\Client\Resources\SiteConfigs\Pages;

use App\Filament\Client\Resources\SiteConfigs\SiteConfigResource;
use Filament\Resources\Pages\EditRecord;

class EditSiteConfig extends EditRecord
{
    protected static string $resource = SiteConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Sem exclusão: o cliente não remove o próprio site.
        ];
    }
}
