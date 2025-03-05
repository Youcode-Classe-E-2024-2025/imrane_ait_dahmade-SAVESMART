<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BudgetOptimizer
{
    // Règle 50/30/20
    const NEEDS_PERCENTAGE = 50;
    const WANTS_PERCENTAGE = 30;
    const SAVINGS_PERCENTAGE = 20;

    /**
     * Optimise le budget selon la règle 50/30/20
     *
     * @param float $income Le revenu total
     * @return array Le plan budgétaire optimisé
     */
    public function optimize($income)
    {
        $needs = ($income * self::NEEDS_PERCENTAGE) / 100;
        $wants = ($income * self::WANTS_PERCENTAGE) / 100;
        $savings = ($income * self::SAVINGS_PERCENTAGE) / 100;

        return [
            'needs' => [
                'percentage' => self::NEEDS_PERCENTAGE,
                'amount' => $needs,
                'description' => 'Besoins essentiels (logement, nourriture, transport, santé)',
            ],
            'wants' => [
                'percentage' => self::WANTS_PERCENTAGE,
                'amount' => $wants,
                'description' => 'Envies et loisirs (restaurants, divertissement, shopping)',
            ],
            'savings' => [
                'percentage' => self::SAVINGS_PERCENTAGE,
                'amount' => $savings,
                'description' => 'Épargne et investissements',
            ],
        ];
    }

    /**
     * Compare le budget actuel avec le budget optimisé
     *
     * @return array Comparaison entre le budget actuel et optimisé
     */
    public function compareWithActual()
    {
        $user = Auth::user();
        
        // Get current month's data
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $transactions = Transaction::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->with('category')
            ->get();
        
        $income = $transactions->where('type', 'income')->sum('amount');
        
        // Calculate optimized budget
        $optimizedBudget = $this->optimize($income);
        
        // Calculate actual spending by budget type
        $actualSpending = [
            'needs' => 0,
            'wants' => 0,
            'savings' => 0,
            'uncategorized' => 0,
        ];
        
        foreach ($transactions as $transaction) {
            if ($transaction->type === 'expense') {
                $budgetType = $transaction->category->budget_type ?? 'uncategorized';
                $actualSpending[$budgetType] += $transaction->amount;
            }
        }
        
        // Calculate differences
        $differences = [
            'needs' => $actualSpending['needs'] - $optimizedBudget['needs']['amount'],
            'wants' => $actualSpending['wants'] - $optimizedBudget['wants']['amount'],
            'savings' => $actualSpending['savings'] - $optimizedBudget['savings']['amount'],
        ];
        
        // Calculate percentages of actual spending
        $totalExpenses = array_sum($actualSpending);
        $actualPercentages = [
            'needs' => $totalExpenses > 0 ? ($actualSpending['needs'] / $totalExpenses) * 100 : 0,
            'wants' => $totalExpenses > 0 ? ($actualSpending['wants'] / $totalExpenses) * 100 : 0,
            'savings' => $totalExpenses > 0 ? ($actualSpending['savings'] / $totalExpenses) * 100 : 0,
            'uncategorized' => $totalExpenses > 0 ? ($actualSpending['uncategorized'] / $totalExpenses) * 100 : 0,
        ];
        
        return [
            'optimized' => $optimizedBudget,
            'actual' => [
                'spending' => $actualSpending,
                'percentages' => $actualPercentages,
            ],
            'differences' => $differences,
        ];
    }

    /**
     * Génère des recommandations basées sur la comparaison du budget
     *
     * @return array Recommandations pour améliorer le budget
     */
    public function generateRecommendations()
    {
        $comparison = $this->compareWithActual();
        $recommendations = [];
        
        // Check if spending in each category is over budget
        if ($comparison['differences']['needs'] > 0) {
            $recommendations[] = [
                'type' => 'warning',
                'category' => 'needs',
                'message' => 'Vos dépenses pour les besoins essentiels dépassent le budget recommandé de ' . number_format($comparison['differences']['needs'], 2) . ' €.',
                'suggestion' => 'Essayez de réduire vos dépenses de logement ou de transport, ou cherchez des moyens d\'économiser sur l\'alimentation.',
            ];
        }
        
        if ($comparison['differences']['wants'] > 0) {
            $recommendations[] = [
                'type' => 'warning',
                'category' => 'wants',
                'message' => 'Vos dépenses pour les loisirs dépassent le budget recommandé de ' . number_format($comparison['differences']['wants'], 2) . ' €.',
                'suggestion' => 'Réduisez les sorties au restaurant ou les achats non essentiels pour rester dans votre budget.',
            ];
        }
        
        if ($comparison['differences']['savings'] < 0) {
            $recommendations[] = [
                'type' => 'warning',
                'category' => 'savings',
                'message' => 'Vous n\'atteignez pas votre objectif d\'épargne de ' . number_format(abs($comparison['differences']['savings']), 2) . ' €.',
                'suggestion' => 'Augmentez vos versements d\'épargne automatiques ou réduisez vos dépenses dans d\'autres catégories.',
            ];
        }
        
        // Check if there are uncategorized expenses
        if ($comparison['actual']['spending']['uncategorized'] > 0) {
            $recommendations[] = [
                'type' => 'info',
                'category' => 'uncategorized',
                'message' => 'Vous avez ' . number_format($comparison['actual']['spending']['uncategorized'], 2) . ' € de dépenses non catégorisées.',
                'suggestion' => 'Catégorisez ces dépenses pour mieux suivre votre budget.',
            ];
        }
        
        return $recommendations;
    }
}

