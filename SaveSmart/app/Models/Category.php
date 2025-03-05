<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'color',
        'icon',
        'type', // 'income', 'expense', or 'both'
        'budget_type', // 'needs', 'wants', 'savings'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public static function getDefaultCategories()
    {
        return [
            ['name' => 'Logement', 'color' => '#4299e1', 'icon' => 'home', 'type' => 'expense', 'budget_type' => 'needs'],
            ['name' => 'Alimentation', 'color' => '#48bb78', 'icon' => 'shopping-cart', 'type' => 'expense', 'budget_type' => 'needs'],
            ['name' => 'Transport', 'color' => '#ed8936', 'icon' => 'car', 'type' => 'expense', 'budget_type' => 'needs'],
            ['name' => 'Santé', 'color' => '#f56565', 'icon' => 'heart', 'type' => 'expense', 'budget_type' => 'needs'],
            ['name' => 'Divertissement', 'color' => '#9f7aea', 'icon' => 'film', 'type' => 'expense', 'budget_type' => 'wants'],
            ['name' => 'Shopping', 'color' => '#ed64a6', 'icon' => 'shopping-bag', 'type' => 'expense', 'budget_type' => 'wants'],
            ['name' => 'Restaurants', 'color' => '#667eea', 'icon' => 'utensils', 'type' => 'expense', 'budget_type' => 'wants'],
            ['name' => 'Épargne', 'color' => '#38b2ac', 'icon' => 'piggy-bank', 'type' => 'expense', 'budget_type' => 'savings'],
            ['name' => 'Investissement', 'color' => '#f6ad55', 'icon' => 'chart-line', 'type' => 'expense', 'budget_type' => 'savings'],
            ['name' => 'Salaire', 'color' => '#68d391', 'icon' => 'wallet', 'type' => 'income', 'budget_type' => null],
            ['name' => 'Freelance', 'color' => '#4fd1c5', 'icon' => 'laptop', 'type' => 'income', 'budget_type' => null],
            ['name' => 'Cadeaux', 'color' => '#fc8181', 'icon' => 'gift', 'type' => 'income', 'budget_type' => null],
        ];
    }
}

