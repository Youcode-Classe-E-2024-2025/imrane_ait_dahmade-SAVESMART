<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Goal;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Create a test user if not exists
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Create some categories
        $categories = [
            ['name' => 'Salaire', 'type' => 'income', 'color' => '#4CAF50'],
            ['name' => 'Loyer', 'type' => 'expense', 'color' => '#F44336', 'budget_type' => 'needs'],
            ['name' => 'Alimentation', 'type' => 'expense', 'color' => '#2196F3', 'budget_type' => 'needs'],
            ['name' => 'Loisirs', 'type' => 'expense', 'color' => '#FF9800', 'budget_type' => 'wants'],
            ['name' => 'Épargne', 'type' => 'expense', 'color' => '#9C27B0', 'budget_type' => 'savings'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name'], 'user_id' => $user->id],
                $category
            );
        }

        // Create some transactions
        $transactions = [
            ['type' => 'income', 'amount' => 3000, 'description' => 'Salaire', 'date' => Carbon::now()->subDays(15)],
            ['type' => 'expense', 'amount' => 800, 'description' => 'Loyer', 'date' => Carbon::now()->subDays(10)],
            ['type' => 'expense', 'amount' => 300, 'description' => 'Courses', 'date' => Carbon::now()->subDays(5)],
            ['type' => 'expense', 'amount' => 100, 'description' => 'Restaurant', 'date' => Carbon::now()->subDays(2)],
            ['type' => 'expense', 'amount' => 200, 'description' => 'Épargne', 'date' => Carbon::now()->subDay()],
        ];

        foreach ($transactions as $transaction) {
            $category = Category::where('user_id', $user->id)
                ->where('type', $transaction['type'])
                ->first();

            Transaction::create([
                'user_id' => $user->id,
                'category_id' => $category->id,
                'type' => $transaction['type'],
                'amount' => $transaction['amount'],
                'description' => $transaction['description'],
                'date' => $transaction['date'],
            ]);
        }

        // Create a goal
        Goal::firstOrCreate(
            ['name' => 'Vacances d\'été', 'user_id' => $user->id],
            [
                'target_amount' => 1500,
                'current_amount' => 500,
                'deadline' => Carbon::now()->addMonths(6),
            ]
        );
    }
}

