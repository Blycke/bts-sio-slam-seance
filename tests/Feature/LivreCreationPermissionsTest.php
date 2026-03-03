<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use App\Models\Livre;
use App\Models\Categorie;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LivreCreationPermissionsTest extends TestCase
{
    use RefreshDatabase;

    protected Utilisateur $admin;
    protected Utilisateur $bibliothecaire;
    protected Utilisateur $utilisateur;
    protected Categorie $categorie;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer une catégorie
        $this->categorie = Categorie::factory()->create(['active' => true]);

        // Créer les utilisateurs de test
        $this->admin = Utilisateur::factory()->create(['role' => 'admin']);
        $this->bibliothecaire = Utilisateur::factory()->create(['role' => 'bibliothecaire']);
        $this->utilisateur = Utilisateur::factory()->create(['role' => 'utilisateur']);
    }

    /**
     * Test: L'admin peut voir le formulaire de création de livre
     */
    public function test_admin_can_view_create_form(): void
    {
        $response = $this->actingAs($this->admin)
            ->get('/livres/create');

        $response->assertStatus(200);
        $response->assertViewIs('livres.create');
    }

    /**
     * Test: Le bibliothécaire peut voir le formulaire de création de livre
     */
    public function test_bibliothecaire_can_view_create_form(): void
    {
        $response = $this->actingAs($this->bibliothecaire)
            ->get('/livres/create');

        $response->assertStatus(200);
        $response->assertViewIs('livres.create');
    }

    /**
     * Test: L'utilisateur régulier ne peut pas voir le formulaire de création
     */
    public function test_utilisateur_cannot_view_create_form(): void
    {
        $response = $this->actingAs($this->utilisateur)
            ->get('/livres/create');

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
    }

    /**
     * Test: L'utilisateur non connecté est redirigé vers login
     */
    public function test_unauthenticated_cannot_view_create_form(): void
    {
        $response = $this->get('/livres/create');

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /**
     * Test: L'admin peut créer un livre
     */
    public function test_admin_can_create_livre(): void
    {
        $livreData = [
            'titre' => 'Test Book',
            'auteur' => 'Test Author',
            'annee' => 2024,
            'nb_pages' => 300,
            'isbn' => '123-456-789',
            'resume' => 'Un test',
            'categorie_id' => $this->categorie->id,
            'disponible' => true,
        ];

        $response = $this->actingAs($this->admin)
            ->post('/livres', $livreData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('livres', ['titre' => 'Test Book']);
    }

    /**
     * Test: Le bibliothécaire peut créer un livre
     */
    public function test_bibliothecaire_can_create_livre(): void
    {
        $livreData = [
            'titre' => 'Bibliothecaire Book',
            'auteur' => 'Biblio Author',
            'annee' => 2025,
            'nb_pages' => 250,
            'isbn' => '987-654-321',
            'resume' => 'Biblio test',
            'categorie_id' => $this->categorie->id,
            'disponible' => false,
        ];

        $response = $this->actingAs($this->bibliothecaire)
            ->post('/livres', $livreData);

        $response->assertStatus(302);
        $this->assertDatabaseHas('livres', ['titre' => 'Bibliothecaire Book']);
    }

    /**
     * Test: L'utilisateur régulier ne peut pas créer un livre
     */
    public function test_utilisateur_cannot_create_livre(): void
    {
        $livreData = [
            'titre' => 'Should Fail',
            'auteur' => 'Should Not Work',
            'categorie_id' => $this->categorie->id,
        ];

        $response = $this->actingAs($this->utilisateur)
            ->post('/livres', $livreData);

        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
        $this->assertDatabaseMissing('livres', ['titre' => 'Should Fail']);
    }

    /**
     * Test: Validation des données requises
     */
    public function test_livre_creation_validation(): void
    {
        // Manque le titre
        $response = $this->actingAs($this->admin)
            ->post('/livres', [
                'auteur' => 'Test',
                'categorie_id' => $this->categorie->id,
            ]);

        $response->assertSessionHasErrors('titre');
    }

    /**
     * Test: La catégorie doit exister
     */
    public function test_livre_requires_valid_categorie(): void
    {
        $response = $this->actingAs($this->admin)
            ->post('/livres', [
                'titre' => 'Test',
                'auteur' => 'Test',
                'categorie_id' => 99999, // Non existent
            ]);

        $response->assertSessionHasErrors('categorie_id');
    }

    /**
     * Test: Le bouton "Ajouter un livre" est visible pour l'admin
     */
    public function test_add_button_visible_for_admin(): void
    {
        $response = $this->actingAs($this->admin)
            ->get('/livres');

        $response->assertSee('Ajouter un livre');
    }

    /**
     * Test: Le bouton "Ajouter un livre" est visible pour le bibliothécaire
     */
    public function test_add_button_visible_for_bibliothecaire(): void
    {
        $response = $this->actingAs($this->bibliothecaire)
            ->get('/livres');

        $response->assertSee('Ajouter un livre');
    }

    /**
     * Test: Le bouton "Ajouter un livre" n'est pas visible pour l'utilisateur
     */
    public function test_add_button_not_visible_for_utilisateur(): void
    {
        $response = $this->actingAs($this->utilisateur)
            ->get('/livres');

        // Le bouton ne doit pas apparaître
        $response->assertDontSee('Ajouter un livre', false);
    }
}
