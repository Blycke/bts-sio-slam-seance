<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategorieFactory extends Factory
{
    protected $model = Categorie::class;

    public function definition()
    {
        $nom = $this->faker->word;
        return [
            'nom' => ucfirst($nom),
            'description' => $this->faker->sentence,
            'slug' => 
                \Str::slug($nom) . '-' . $this->faker->unique()->numberBetween(1,1000),
            'couleur' => '#'.substr(md5($nom),0,6),
            'icone' => 'fas fa-book',
            'active' => true,
        ];
    }
}
