<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Dépenses
            ['name' => 'Alimentation', 'type' => 'expense', 'color' => '#FF5733', 'icon' => '🍽️'],
            ['name' => 'Transport', 'type' => 'expense', 'color' => '#33FF57', 'icon' => '🚗'],
            ['name' => 'Logement', 'type' => 'expense', 'color' => '#3357FF', 'icon' => '🏠'],
            ['name' => 'Factures', 'type' => 'expense', 'color' => '#FF33F5', 'icon' => '📄'],
            ['name' => 'Santé', 'type' => 'expense', 'color' => '#33FFF5', 'icon' => '🏥'],
            ['name' => 'Loisirs', 'type' => 'expense', 'color' => '#F5FF33', 'icon' => '🎮'],
            ['name' => 'Shopping', 'type' => 'expense', 'color' => '#FF3333', 'icon' => '🛍️'],
            ['name' => 'Education', 'type' => 'expense', 'color' => '#33FFB5', 'icon' => '📚'],
            
            // Revenus
            ['name' => 'Salaire', 'type' => 'income', 'color' => '#33FF57', 'icon' => '💰'],
            ['name' => 'Freelance', 'type' => 'income', 'color' => '#5733FF', 'icon' => '💻'],
            ['name' => 'Investissements', 'type' => 'income', 'color' => '#FFB533', 'icon' => '📈'],
            ['name' => 'Cadeaux', 'type' => 'income', 'color' => '#FF33A1', 'icon' => '🎁'],
        ];

        // Récupérer tous les utilisateurs
        $users = User::all();

        foreach ($users as $user) {
            foreach ($categories as $category) {
                Categorie::create([
                    'name' => $category['name'],
                    'type' => $category['type'],
                    'color' => $category['color'],
                    'icon' => $category['icon'],
                    'user_id' => $user->id
                ]);
            }
        }
    }
}
