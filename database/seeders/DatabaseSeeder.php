<?php

namespace Database\Seeders;

use App\Models\Utilisateur as User; // alias français

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeders français pour BiblioTech
        $this->call([
            CategorieSeeder::class,  // Créer d'abord les catégories
            LivreSeeder::class,      // Puis les livres avec relations
        ]);

        // compte administrateur par défaut (utile pour la séance 4)
        User::firstOrCreate([
            'courriel' => 'admin@bibliotech.test'
        ], [
            'nom' => 'Admin',
            'mot_de_passe' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}
