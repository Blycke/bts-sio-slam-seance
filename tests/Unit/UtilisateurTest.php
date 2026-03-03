<?php

namespace Tests\Unit;

use App\Models\Utilisateur as User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UtilisateurTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_admin_method(): void
    {
        $u = User::factory()->create(['role' => 'admin']);
        $this->assertTrue($u->isAdmin());
    }

    public function test_is_bibliothecaire_method(): void
    {
        $u = User::factory()->create(['role' => 'bibliothecaire']);
        $this->assertTrue($u->isBibliothecaire());
    }

    public function test_is_utilisateur_method(): void
    {
        $u = User::factory()->create(['role' => 'utilisateur']);
        $this->assertTrue($u->isUtilisateur());
    }
}
