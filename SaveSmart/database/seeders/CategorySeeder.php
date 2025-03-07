<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultCategories = Category::getDefaultCategories();
        
        foreach ($defaultCategories as $category) {
            Category::create($category);
        }
    }
}
