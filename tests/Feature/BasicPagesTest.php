<?php

namespace Tests\Feature;

use App\Models\Livre;
use App\Models\Categorie;
use Tests\TestCase;

class BasicPagesTest extends TestCase
{
    public function test_catalogue_page_shows_books()
    {
        Categorie::factory()->create(['nom' => 'Test Cat']);
        Livre::factory()->create([ 'titre' => 'MonLivre', 'categorie_id' => 1 ]);

        $response = $this->get('/livres');
        $response->assertStatus(200);
        $response->assertSee('MonLivre');
    }

    public function test_filter_by_search_term()
    {
        Categorie::factory()->create(['nom' => 'Test Cat']);
        Livre::factory()->create([ 'titre' => 'Livre Laravel', 'categorie_id' => 1 ]);
        Livre::factory()->create([ 'titre' => 'Autre', 'categorie_id' => 1 ]);

        $response = $this->get('/livres?q=Laravel');
        $response->assertSee('Livre Laravel');
        $response->assertDontSee('Autre');
    }

    public function test_category_pages()
    {
        $cat = Categorie::factory()->create(['nom' => 'SciFi']);
        Livre::factory()->create([ 'titre' => 'Dune', 'categorie_id' => $cat->id ]);

        $response = $this->get('/categories');
        $response->assertSee('SciFi');

        $response2 = $this->get('/categories/' . $cat->id);
        $response2->assertSee('Dune');
    }
}
