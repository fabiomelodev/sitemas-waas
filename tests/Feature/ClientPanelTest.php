<?php

namespace Tests\Feature;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
}
