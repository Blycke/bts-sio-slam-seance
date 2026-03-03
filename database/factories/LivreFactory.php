<?php

namespace Database\Factories;

use App\Models\Livre;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class LivreFactory extends Factory
{
    protected $model = Livre::class;

    public function definition()
    {
        return [
            'titre' => $this->faker->sentence(3),
            'auteur' => $this->faker->name,
            'annee' => $this->faker->year,
            'nb_pages' => $this->faker->numberBetween(50, 500),
            'isbn' => $this->faker->isbn13,
            'resume' => $this->faker->paragraph,
            'couverture' => null,
            'disponible' => true,
            'categorie_id' => Categorie::factory(),
        ];
    }
}
