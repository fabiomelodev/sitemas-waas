<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Plan;
use App\Models\Template;
use App\Settings\GeneralSettings;

class HomeController extends Controller
{
    public function index(GeneralSettings $settings)
    {
        $plans = Plan::query()->orderBy('order', 'asc')->active()->get();

        // Nichos: apenas categorias com pelo menos um modelo ativo.
        $niches = Category::query()->active()
            ->withCount(['templates' => fn ($query) => $query->active()])
            ->whereHas('templates', fn ($query) => $query->active())
            ->orderBy('name')
            ->get();

        $showcaseTemplates = Template::query()->active()
            ->with('category')
            ->latest()
            ->get();

        return view('pages.home', [
            'plans' => $plans,
            'settings' => $settings,
            'niches' => $niches,
            'showcaseTemplates' => $showcaseTemplates,
        ]);
    }
}
