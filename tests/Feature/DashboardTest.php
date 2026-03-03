<?php

namespace Tests\Feature;

use App\Models\Utilisateur as User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirects_guest_to_login(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_user_sees_user_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'utilisateur']);
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Mon espace');
    }

    public function test_admin_sees_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Tableau de bord administrateur');
    }
}
