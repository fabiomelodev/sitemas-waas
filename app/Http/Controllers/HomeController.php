<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class HomeController extends Controller
{
    public function index()
    {
        $planStart = Plan::where('slug', 'plano-start')->active()->first();

        $planPro = Plan::where('slug', 'plano-pro')->active()->first();

        $plans = Plan::query()->orderBy('order', 'asc')->active()->get();

        return view('pages.home', [
            'planStart' => $planStart,
            'planPro' => $planPro,
            'plans' => $plans,
        ]);
    }
}
