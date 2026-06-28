<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Plan;
use App\Models\Template;
use App\Services\SubscriptionService;
use App\Settings\GeneralSettings;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Template $template, GeneralSettings $settings)
    {
        $plan = $template->plan;

        return view('pages.subscription', [
            'template' => $template,
            'plan' => $plan,
            'settings' => $settings,
        ]);
    }

    public function checkout(Request $request, Plan $plan, Template $template, SubscriptionService $subscriptions)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ]);

        // Mantém o lead para marketing/recuperação de carrinho.
        Lead::updateOrCreate(
            ['email' => $data['email']],
            ['template_id' => $template->id, 'plan_id' => $plan->id, 'phone' => $data['phone']]
        );

        try {
            // Cria cliente + assinatura no Asaas e devolve a URL de pagamento.
            $checkoutUrl = $subscriptions->startSubscription($data, $plan, $template);
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withErrors(['message' => 'Não foi possível iniciar sua assinatura. Tente novamente em instantes.'])
                ->withInput();
        }

        return redirect()->away($checkoutUrl);
    }

    /**
     * Display the success message after payment confirmation.
     */
    public function success(GeneralSettings $settings)
    {
        return view('payments.success', ['settings' => $settings]);
    }
}
