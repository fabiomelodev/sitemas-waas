<?php

namespace Tests\Feature;

use App\Jobs\ProcessAsaasWebhook;
use App\Models\Category;
use App\Models\Order;
use App\Models\Plan;
use App\Models\SiteConfig;
use App\Models\Subscription;
use App\Models\Template;
use App\Models\User;
use App\Notifications\PaymentConfirmed;
use App\Notifications\WelcomeAndSetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AsaasSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.asaas.env' => 'sandbox',
            'services.asaas.sandbox_url' => 'https://api-sandbox.asaas.com/v3',
            'services.asaas.sandbox_token' => 'fake-token',
            'services.asaas.sandbox_webhook_token' => 'fake-webhook-token',
        ]);
    }

    private function makeTemplate(): Template
    {
        $plan = Plan::create([
            'name' => 'Plano Pro',
            'description' => 'Plano completo',
            'price' => 99.90,
            'features' => [['name' => 'Hospedagem', 'status' => 1]],
            'status' => 'active',
        ]);

        $category = Category::create(['name' => 'Barbearia', 'status' => 'active']);

        return Template::create([
            'name' => 'Barber Premium',
            'excerpt' => 'Modelo para barbearias',
            'url' => 'https://demo.test',
            'category_id' => $category->id,
            'plan_id' => $plan->id,
            'status' => 'active',
        ]);
    }

    public function test_checkout_creates_asaas_customer_subscription_and_redirects_to_payment(): void
    {
        Http::fake([
            '*/customers' => Http::response(['id' => 'cus_123', 'name' => 'Maria', 'email' => 'maria@test.com']),
            '*/subscriptions/*/payments' => Http::response(['data' => [['id' => 'pay_1', 'invoiceUrl' => 'https://asaas.test/c/abc']]]),
            '*/subscriptions' => Http::response(['id' => 'sub_123']),
        ]);

        $template = $this->makeTemplate();

        $response = $this->post(route('subscription.checkout', ['plan' => $template->plan, 'template' => $template]), [
            'name' => 'Maria da Silva',
            'email' => 'maria@test.com',
            'phone' => '(11) 91234-5678',
            'cpf_cnpj' => '123.456.789-00',
        ]);

        $response->assertRedirect('https://asaas.test/c/abc');

        $user = User::where('email', 'maria@test.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('cus_123', $user->asaas_customer_id);
        $this->assertFalse($user->is_admin);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'asaas_subscription_id' => 'sub_123',
            'status' => 'pending',
            'plan_id' => $template->plan_id,
            'template_id' => $template->id,
        ]);

        $this->assertDatabaseHas('leads', [
            'email' => 'maria@test.com',
            'plan_id' => $template->plan_id,
        ]);
    }

    public function test_webhook_rejects_invalid_token(): void
    {
        Bus::fake();

        $this->postJson(route('asaas.webhook'), ['event' => 'PAYMENT_CONFIRMED'], [
            'asaas-access-token' => 'wrong',
        ])->assertStatus(401);

        Bus::assertNotDispatched(ProcessAsaasWebhook::class);
    }

    public function test_valid_webhook_dispatches_job(): void
    {
        Bus::fake();

        $this->postJson(route('asaas.webhook'), ['event' => 'PAYMENT_CONFIRMED', 'payment' => ['id' => 'pay_1']], [
            'asaas-access-token' => 'fake-webhook-token',
        ])->assertOk();

        Bus::assertDispatched(ProcessAsaasWebhook::class);
    }

    public function test_confirmed_payment_activates_subscription_and_notifies(): void
    {
        Notification::fake();

        $template = $this->makeTemplate();

        $user = User::create([
            'name' => 'Maria da Silva',
            'email' => 'maria@test.com',
            'asaas_customer_id' => 'cus_123',
            'password' => bcrypt('x'),
        ]);

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'asaas_subscription_id' => 'sub_123',
            'status' => 'pending',
            'plan_id' => $template->plan_id,
            'template_id' => $template->id,
        ]);

        // QUEUE_CONNECTION=sync -> o job roda imediatamente.
        ProcessAsaasWebhook::dispatch([
            'event' => 'PAYMENT_CONFIRMED',
            'payment' => [
                'id' => 'pay_1',
                'value' => 99.90,
                'billingType' => 'PIX',
                'subscription' => 'sub_123',
                'customer' => 'cus_123',
            ],
        ]);

        $subscription->refresh();
        $this->assertSame('active', $subscription->status);
        $this->assertNotNull($subscription->expires_at);

        $this->assertDatabaseHas('orders', [
            'asaas_payment_id' => 'pay_1',
            'status' => 'completed',
            'payment_method' => 'PIX',
            'subscription_id' => $subscription->id,
        ]);

        $this->assertDatabaseHas('site_configs', ['subscription_id' => $subscription->id]);

        Notification::assertSentTo($user, WelcomeAndSetPassword::class);
        Notification::assertSentTo($user, PaymentConfirmed::class);
    }

    public function test_confirmed_payment_is_idempotent(): void
    {
        Notification::fake();

        $template = $this->makeTemplate();
        $user = User::create([
            'name' => 'Maria', 'email' => 'maria@test.com',
            'asaas_customer_id' => 'cus_123', 'password' => bcrypt('x'),
        ]);
        $subscription = Subscription::create([
            'user_id' => $user->id, 'asaas_subscription_id' => 'sub_123',
            'status' => 'pending', 'plan_id' => $template->plan_id, 'template_id' => $template->id,
        ]);

        $payload = [
            'event' => 'PAYMENT_CONFIRMED',
            'payment' => ['id' => 'pay_1', 'value' => 99.90, 'billingType' => 'PIX', 'subscription' => 'sub_123'],
        ];

        ProcessAsaasWebhook::dispatch($payload);
        ProcessAsaasWebhook::dispatch($payload);

        $this->assertSame(1, Order::where('asaas_payment_id', 'pay_1')->count());
        $this->assertSame(1, SiteConfig::where('subscription_id', $subscription->id)->count());
    }
}
