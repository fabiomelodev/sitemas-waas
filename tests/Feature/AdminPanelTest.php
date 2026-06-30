<?php

namespace Tests\Feature;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_load_dashboard_with_widgets(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'is_admin' => true,
            'password' => bcrypt('secret'),
        ]);

        // Carregar o dashboard executa o mount/render dos widgets (stats, chart,
        // tabela). Um 200 confirma que nenhum deles dá fatal.
        $this->actingAs($admin)->get('/admin')->assertOk();
    }

    public function test_customer_cannot_access_admin_panel(): void
    {
        $customer = User::create([
            'name' => 'Cliente',
            'email' => 'cliente@test.com',
            'is_admin' => false,
            'password' => bcrypt('secret'),
        ]);

        $this->actingAs($customer)->get('/admin')->assertForbidden();
    }

    public function test_users_resource_lists_only_clients(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'is_admin' => true,
            'password' => bcrypt('secret'),
        ]);
        $client = User::create([
            'name' => 'Cliente',
            'email' => 'cliente@test.com',
            'is_admin' => false,
            'password' => bcrypt('secret'),
        ]);

        $ids = UserResource::getEloquentQuery()->pluck('id');

        $this->assertTrue($ids->contains($client->id));
        $this->assertSame(0, UserResource::getEloquentQuery()->where('is_admin', true)->count());
    }

    public function test_admin_can_access_profile_page(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'is_admin' => true,
            'password' => bcrypt('secret'),
        ]);

        $this->actingAs($admin)->get('/admin/profile')->assertOk();
    }
}
