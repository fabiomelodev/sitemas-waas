<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_access_client_panel(): void
    {
        $client = User::create([
            'name' => 'Cliente',
            'email' => 'cliente@test.com',
            'is_admin' => false,
            'password' => bcrypt('secret'),
        ]);

        $this->actingAs($client)->get('/painel')->assertOk();
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
