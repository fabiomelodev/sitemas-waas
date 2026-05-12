<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $planStart = Plan::where('slug', 'plano-start')->active()->first();

        $planPro = Plan::where('slug', 'plano-pro')->active()->first();

        return view('pages.home', [
            'planStart' => $planStart,
            'planPro' => $planPro,
        ]);
    }
}
