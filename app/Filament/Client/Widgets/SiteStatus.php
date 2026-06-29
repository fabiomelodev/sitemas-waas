<?php

namespace App\Filament\Client\Widgets;

use App\Models\SiteConfig;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class SiteStatus extends Widget
{
    protected static ?int $sort = 2;

    protected static bool $isLazy = false;

    protected string $view = 'filament.client.widgets.site-status';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $siteConfig = SiteConfig::query()
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        return [
            'currentStage' => $siteConfig?->stage ?? 'received',
            'stages' => SiteConfig::STAGES,
        ];
    }
}
