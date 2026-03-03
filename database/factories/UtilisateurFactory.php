<?php

namespace Database\Factories;

use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UtilisateurFactory extends Factory
{
    protected $model = Utilisateur::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->name(),
            'courriel' => $this->faker->unique()->safeEmail(),
            'courriel_verifie_le' => now(),
            'mot_de_passe' => Hash::make('password'),
            'role' => 'utilisateur',
            'remember_token' => Str::random(10),
        ];
    }

    public function admin()
    {
        return $this->state([ 'role' => 'admin' ]);
    }

    public function bibliothecaire()
    {
        return $this->state([ 'role' => 'bibliothecaire' ]);
    }
}
