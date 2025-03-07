<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Goal;
use App\Services\BudgetOptimizer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    protected $budgetOptimizer;

    public function __construct(BudgetOptimizer $budgetOptimizer)
    {
        $this->budgetOptimizer = $budgetOptimizer;
    }

    public function index()
    {
        $user = Auth::user();
        
        // Récupérer toutes les transactions pour déboguer
        $allTransactions = Transaction::where('user_id', $user->id)->get();
        Log::info('Toutes les transactions:', $allTransactions->toArray());

        // Get current month's data with less restrictive date filtering
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
        
        $transactions = Transaction::where('user_id', $user->id)
            ->whereDate('date', '>=', $startOfMonth)
            ->whereDate('date', '<=', $endOfMonth)
            ->get();
        
        Log::info('Transactions du mois:', [
            'début' => $startOfMonth,
            'fin' => $endOfMonth,
            'transactions' => $transactions->toArray()
        ]);
        
        // Calculer les totaux
        $income = $transactions->where('type', 'income')->sum('amount');
        $expenses = $transactions->where('type', 'expense')->sum('amount');
        $balance = $income - $expenses;
        
        // Log debug information
        Log::info('Données du tableau de bord:', [
            'user_id' => $user->id,
            'nombre_transactions' => $transactions->count(),
            'revenus' => $income,
            'dépenses' => $expenses,
            'solde' => $balance,
        ]);
        
        // Get budget optimization
        $budgetPlan = [
            'needs' => [
                'percentage' => 50,
                'amount' => $income * 0.5,
            ],
            'wants' => [
                'percentage' => 30,
                'amount' => $income * 0.3,
            ],
            'savings' => [
                'percentage' => 20,
                'amount' => $income * 0.2,
            ],
        ];
        
        // Get actual spending by category
        $categories = Category::where(function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhereNull('user_id');
        })->get();
        
        Log::info('Catégories:', $categories->toArray());
        
        $categorySpending = [];
        foreach ($categories as $category) {
            $spent = $transactions->where('category_id', $category->id)
                ->where('type', 'expense')
                ->sum('amount');
            
            if ($spent > 0) {
                $categorySpending[] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'color' => $category->color ?? '#'.substr(md5($category->name), 0, 6),
                    'amount' => $spent,
                    'percentage' => $expenses > 0 ? round(($spent / $expenses) * 100, 2) : 0,
                ];
            }
        }
        
        // Get goals
        $goals = Goal::where('user_id', $user->id)->get();
        
        return view('dashboard', compact(
            'income',
            'expenses',
            'balance',
            'budgetPlan',
            'categorySpending',
            'goals'
        ));
    }
}

