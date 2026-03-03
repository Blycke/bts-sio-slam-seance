<?php

namespace Tests\Feature;

use App\Models\Utilisateur as User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_login()
    {
        $user = User::create([
            'nom' => 'Test Utilisateur',
            'courriel' => 'test@example.com',
            'mot_de_passe' => Hash::make('password123'),
            'role' => 'utilisateur',
        ]);

        $response = $this->post('/login', [
            'courriel' => 'test@example.com',
            'mot_de_passe' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }

    public function test_login_fails_with_invalid_credentials()
    {
        User::create([
            'nom' => 'Test Utilisateur',
            'courriel' => 'test@example.com',
            'mot_de_passe' => Hash::make('password123'),
            'role' => 'utilisateur',
        ]);

        $response = $this->post('/login', [
            'courriel' => 'test@example.com',
            'mot_de_passe' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('courriel');
    }

    public function test_user_can_register()
    {
        $response = $this->post('/register', [
            'nom' => 'Nouvel User',
            'courriel' => 'new@example.com',
            'mot_de_passe' => 'password123',
            'mot_de_passe_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('utilisateurs', [
            'courriel' => 'new@example.com',
            'nom' => 'Nouvel User',
        ]);

        $response->assertRedirect('/dashboard');
    }

    public function test_admin_can_view_all_users()
    {
        $admin = User::create([
            'nom' => 'Admin',
            'courriel' => 'admin@example.com',
            'mot_de_passe' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/admin/utilisateurs');

        $response->assertStatus(200);
        $response->assertViewIs('admin.users.index');
    }

    public function test_user_cannot_view_users_list()
    {
        $user = User::create([
            'nom' => 'User',
            'courriel' => 'user@example.com',
            'mot_de_passe' => Hash::make('password123'),
            'role' => 'utilisateur',
        ]);

        $response = $this->actingAs($user)->get('/admin/utilisateurs');
        $response->assertRedirect('/dashboard');
    }

    public function test_admin_can_delete_user()
    {
        $admin = User::create([
            'nom' => 'Admin',
            'courriel' => 'admin@example.com',
            'mot_de_passe' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $userToDelete = User::create([
            'nom' => 'À supprimer',
            'courriel' => 'delete@example.com',
            'mot_de_passe' => Hash::make('password123'),
            'role' => 'utilisateur',
        ]);

        $response = $this->actingAs($admin)->delete('/admin/utilisateurs/' . $userToDelete->id);

        // la table n'utilise pas SoftDeletes dans cet exemple,
        // on vérifie simplement que l'enregistrement a disparu.
        $this->assertDatabaseMissing('utilisateurs', ['id' => $userToDelete->id]);
        $response->assertRedirect('/admin/utilisateurs');
    }

    public function test_user_can_update_profile()
    {
        $user = User::create([
            'nom' => 'Ancien',
            'courriel' => 'old@example.com',
            'mot_de_passe' => Hash::make('password123'),
            'role' => 'utilisateur',
        ]);

        $response = $this->actingAs($user)->patch('/profile/update', [
            'nom' => 'Nouveau',
            'courriel' => 'new@example.com',
        ]);

        $this->assertDatabaseHas('utilisateurs', [
            'id' => $user->id,
            'nom' => 'Nouveau',
            'courriel' => 'new@example.com',
        ]);

        $response->assertStatus(302);
    }

    public function test_user_can_change_password()
    {
        $user = User::create([
            'nom' => 'User',
            'courriel' => 'user@example.com',
            'mot_de_passe' => Hash::make('oldpassword'),
            'role' => 'utilisateur',
        ]);

        $response = $this->actingAs($user)->patch('/profile/password', [
            'current_password' => 'oldpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $this->assertTrue(Hash::check('newpassword123', $user->fresh()->mot_de_passe));
        $response->assertStatus(302);
    }
}
