<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Settings\GeneralSettings;

class HomeController extends Controller
{
    public function index(GeneralSettings $settings)
    {
        $plans = Plan::query()->orderBy('order', 'asc')->active()->get();

        return view('pages.home', [
            'plans' => $plans,
            'settings' => $settings,
        ]);
    }
}
