<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Goal;
use App\Services\BudgetOptimizer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        // Get current month's data
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $transactions = Transaction::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get();
        
        $income = $transactions->where('type', 'income')->sum('amount');
        $expenses = $transactions->where('type', 'expense')->sum('amount');
        $balance = $income - $expenses;
        
        // Get budget optimization
        $budgetPlan = $this->budgetOptimizer->optimize($income);
        
        // Get actual spending by category
        $categories = Category::where('user_id', $user->id)
            ->orWhereNull('user_id')
            ->get();
        
        $categorySpending = [];
        foreach ($categories as $category) {
            $spent = $transactions->where('category_id', $category->id)
                ->where('type', 'expense')
                ->sum('amount');
            
            if ($spent > 0) {
                $categorySpending[] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'color' => $category->color,
                    'amount' => $spent,
                    'percentage' => $expenses > 0 ? round(($spent / $expenses) * 100) : 0,
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

