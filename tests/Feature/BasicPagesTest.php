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

    public function test_welcome_page_shows_cover_stats()
    {
        Categorie::factory()->create(['nom' => 'Test Cat']);
        // one book with cover, one without
        Livre::factory()->create([ 'titre' => 'AvecCouverture', 'categorie_id' => 1, 'couverture' => 'cover.jpg' ]);
        Livre::factory()->create([ 'titre' => 'SansCouverture', 'categorie_id' => 1, 'couverture' => null ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeText('Avec couvertures');
        // percentage is wrapped in <sup>, use text assertion
        $response->assertSeeText('50%');
    }
}
