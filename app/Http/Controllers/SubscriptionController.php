<?php

namespace App\Http\Controllers;

use App\Models\{Lead, Plan, Template};
use App\Services\AsaasService;
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

    public function checkout(Request $request, Plan $plan, Template $template, AsaasService $asaasService)
    {
        dd($plan, $template);

        // 1. Validamos o e-mail que veio do seu formulário modal
        $request->validate([
            'email' => 'required|email',
        ]);

        // 2. Preparamos o nome do item que aparecerá no checkout do Asaas
        // Ex: "Premium Plan - Template: Barber Shop"
        $description = "Plan: {$plan->name} - Design: {$template->name}";

        // 3. Pegamos o valor do plano dinamicamente do banco de dados
        $amount = (float) $plan->price;

        // 4. Chamamos o serviço para gerar o link na API do Asaas
        $paymentLink = $asaasService->createPaymentLink($description, $amount);

        if (isset($paymentLink['url'])) {
            // DICA: Você pode salvar o e-mail na sessão ou criar um registro 
            // "pendente" no banco antes de redirecionar para vincular depois no webhook.
            session(['checkout_email' => $request->email]);

            return redirect()->away($paymentLink['url']);
        }

        return back()->withErrors([
            'message' => 'Unable to generate payment link. Please try again later.'
        ]);
    }

    /**
     * Display the success message after payment confirmation.
     */
    public function success()
    {
        return view('payments.success');
    }
}
