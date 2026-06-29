<?php

namespace Tests\Feature;

use App\Models\SiteConfig;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\SubscriptionCanceledNotification;
use App\Notifications\WelcomeAndSetPassword;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ClientPanelTest extends TestCase
{
    use RefreshDatabase;

    private function makeClient(?string $subscriptionStatus = null): User
    {
        $client = User::create([
            'name' => 'Cliente',
            'email' => 'cliente@test.com',
            'is_admin' => false,
            'password' => bcrypt('secret'),
        ]);

        if ($subscriptionStatus) {
            Subscription::create([
                'user_id' => $client->id,
                'status' => $subscriptionStatus,
            ]);
        }

        return $client;
    }

    public function test_client_with_active_subscription_can_access_panel(): void
    {
        $client = $this->makeClient('active');

        $this->actingAs($client)->get('/painel')->assertOk();
    }

    public function test_dashboard_shows_site_status_widget(): void
    {
        $client = $this->makeClient('active');
        SiteConfig::create([
            'company_name' => 'Empresa X',
            'user_id' => $client->id,
            'stage' => 'in_progress',
        ]);

        $this->actingAs($client)->get('/painel')
            ->assertOk()
            ->assertSee('Status do seu site')
            ->assertSee('Em configuração')
            ->assertSee('ss-step', false); // markup estilizado (CSS próprio) presente
    }

    public function test_client_without_subscription_cannot_access_panel(): void
    {
        $client = $this->makeClient();

        $this->actingAs($client)->get('/painel')->assertForbidden();
    }

    public function test_client_with_inactive_subscription_cannot_access_panel(): void
    {
        $client = $this->makeClient('past_due');

        $this->actingAs($client)->get('/painel')->assertForbidden();
    }

    public function test_canceled_within_paid_period_keeps_access(): void
    {
        $client = User::create([
            'name' => 'Cancelado Vigente',
            'email' => 'cancelado-vigente@test.com',
            'is_admin' => false,
            'password' => bcrypt('secret'),
        ]);
        Subscription::create([
            'user_id' => $client->id,
            'status' => 'canceled',
            'expires_at' => now()->addDays(10),
        ]);

        $this->actingAs($client)->get('/painel')->assertOk();
    }

    public function test_canceled_after_paid_period_loses_access(): void
    {
        $client = User::create([
            'name' => 'Cancelado Expirado',
            'email' => 'cancelado-expirado@test.com',
            'is_admin' => false,
            'password' => bcrypt('secret'),
        ]);
        Subscription::create([
            'user_id' => $client->id,
            'status' => 'canceled',
            'expires_at' => now()->subDay(),
        ]);

        $this->actingAs($client)->get('/painel')->assertForbidden();
    }

    public function test_admin_cannot_access_client_panel(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'is_admin' => true,
            'password' => bcrypt('secret'),
        ]);

        $this->actingAs($admin)->get('/painel')->assertForbidden();
    }

    public function test_guest_is_redirected_to_client_login(): void
    {
        $this->get('/painel')->assertRedirect('/painel/login');
    }

    public function test_client_can_open_own_site_config(): void
    {
        $client = $this->makeClient('active');
        $config = SiteConfig::create(['company_name' => 'Minha Empresa', 'user_id' => $client->id]);

        $this->actingAs($client)->get('/painel/site-configs')->assertOk();
        $this->actingAs($client)->get("/painel/site-configs/{$config->getKey()}/edit")->assertOk();
    }

    public function test_client_can_view_subscription_and_orders_pages(): void
    {
        $client = $this->makeClient('active');

        $this->actingAs($client)->get('/painel/subscriptions')->assertOk();
        $this->actingAs($client)->get('/painel/orders')->assertOk();
    }

    public function test_client_can_access_support_pages(): void
    {
        $client = $this->makeClient('active');

        $this->actingAs($client)->get('/painel/support-tickets')->assertOk();
        $this->actingAs($client)->get('/painel/support-tickets/create')->assertOk();
    }

    public function test_cancel_subscription_is_idempotent(): void
    {
        Notification::fake();

        $client = $this->makeClient('active');
        $subscription = $client->subscriptions()->first();
        $subscription->update(['asaas_subscription_id' => 'sub_x']);

        $service = app(PaymentService::class);
        $service->cancelSubscription('sub_x');
        $service->cancelSubscription('sub_x'); // segunda chamada não deve reprocessar

        $this->assertSame('canceled', $subscription->fresh()->status);
        Notification::assertSentToTimes($client, SubscriptionCanceledNotification::class, 1);
    }

    public function test_setting_password_logs_the_client_into_the_panel(): void
    {
        $client = $this->makeClient('active');
        $token = Password::createToken($client);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $client->email,
            'password' => 'nova-senha-123',
            'password_confirmation' => 'nova-senha-123',
        ]);

        $response->assertRedirect(route('filament.client.pages.dashboard'));
        $this->assertAuthenticatedAs($client);
        $this->assertNotNull($client->fresh()->password_set_at);
    }

    public function test_resend_sends_a_fresh_account_link(): void
    {
        Notification::fake();

        $client = $this->makeClient('active');

        $this->post('/reset-password/reenviar', ['email' => $client->email])
            ->assertSessionHas('status');

        Notification::assertSentTo($client, WelcomeAndSetPassword::class);
    }

    public function test_invalid_token_shows_error_and_keeps_password_unset(): void
    {
        $client = $this->makeClient('active');

        $response = $this->post('/reset-password', [
            'token' => 'token-invalido',
            'email' => $client->email,
            'password' => 'nova-senha-123',
            'password_confirmation' => 'nova-senha-123',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
        $this->assertNull($client->fresh()->password_set_at);
    }

    public function test_client_cannot_open_another_clients_site_config(): void
    {
        $clientA = $this->makeClient('active');

        $clientB = User::create([
            'name' => 'Cliente B',
            'email' => 'cliente-b@test.com',
            'is_admin' => false,
            'password' => bcrypt('secret'),
        ]);
        Subscription::create(['user_id' => $clientB->id, 'status' => 'active']);
        $configB = SiteConfig::create(['company_name' => 'Empresa B', 'user_id' => $clientB->id]);

        $this->actingAs($clientA)->get("/painel/site-configs/{$configB->getKey()}/edit")->assertNotFound();
    }
}
