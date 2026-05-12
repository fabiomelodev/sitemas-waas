<?php

namespace App\Http\Controllers;

use App\Models\{Lead, Plan, Template};
use App\Settings\GeneralSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template, GeneralSettings $settings)
    {
        $plan = $template->plan;

        return view('pages.subscription', [
            'template' => $template,
            'plan' => $plan,
            'settings' => $settings
        ]);
    }

    public function checkout(Plan $plan, Template $template, Request $request)
    {
        $email = $request->input('email');

        Lead::updateOrCreate(
            ['email' => $email],
            ['template_id' => $template->id]
        );

        return redirect()->to($plan->url);
    }
}
