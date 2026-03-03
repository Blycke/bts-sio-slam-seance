<?php

namespace Tests\Feature;

use App\Models\Livre;
use App\Models\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LivreTest extends TestCase
{
    use RefreshDatabase;

    public function test_livres_page_loads(): void
    {
        Categorie::factory()->create();

        $response = $this->get('/livres');
        $response->assertStatus(200);
    }

    public function test_livre_detail_loads(): void
    {
        $livre = Livre::factory()->for(Categorie::factory())->create();

        $response = $this->get("/livre/{$livre->id}");
        $response->assertStatus(200);
        $response->assertSee($livre->titre);
    }

    public function test_can_search_livres(): void
    {
        Categorie::factory()->create();
        Livre::factory()->count(3)->create([ 'titre' => 'Laravel pour les Nuls' ]);
        Livre::factory()->create([ 'titre' => 'Autre livre' ]);

        $response = $this->get('/livres?q=Laravel');
        $response->assertStatus(200);
        $response->assertSee('Laravel pour les Nuls');
        $response->assertDontSee('Autre livre');
    }
}
