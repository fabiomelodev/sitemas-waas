<?php

namespace App\Filament\Client\Widgets;

use App\Models\SiteConfig;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class SiteStatus extends Widget
{
    protected static ?int $sort = 2;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.client.widgets.site-status';

    public static function canView(): bool
    {
        return SiteConfig::query()->where('user_id', Auth::id())->exists();
    }

    protected function getViewData(): array
    {
        return [
            'sites' => SiteConfig::query()
                ->where('user_id', Auth::id())
                ->latest()
                ->get(),
            'stages' => SiteConfig::STAGES,
        ];
    }
}
