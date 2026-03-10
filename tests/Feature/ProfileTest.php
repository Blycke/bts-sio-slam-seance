<?php

namespace Tests\Feature;

use App\Models\Utilisateur as User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_upload_profile_photo()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user);

        // use create() to avoid GD requirement in container
        $file = UploadedFile::fake()->create('avatar.jpg', 100, 'image/jpeg');

        $response = $this->patch(route('profile.update'), [
            'nom' => 'Nouveau Nom',
            'courriel' => $user->courriel,
            'photo' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // stocké dans disk
        Storage::disk('public')->assertExists('profiles/' . $file->hashName());

        $this->assertDatabaseHas('utilisateurs', [
            'id' => $user->id,
            'photo' => $file->hashName(),
            'nom' => 'Nouveau Nom',
        ]);
    }

    public function test_profile_edit_page_shows_current_photo()
    {
        $user = User::factory()->create(['photo' => 'existing.jpg']);
        $this->actingAs($user);

        $response = $this->get(route('profile.edit'));
        $response->assertStatus(200);
        $response->assertSee('existing.jpg');
    }
}
