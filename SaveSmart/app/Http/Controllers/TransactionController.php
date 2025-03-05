<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)
            ->with('category')
            ->orderBy('date', 'desc')
            ->paginate(15);
        
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $user = Auth::user();
        $incomeCategories = Category::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereNull('user_id');
            })
            ->where(function($query) {
                $query->where('type', 'income')
                    ->orWhere('type', 'both');
            })
            ->get();
        
        $expenseCategories = Category::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereNull('user_id');
            })
            ->where(function($query) {
                $query->where('type', 'expense')
                    ->orWhere('type', 'both');
            })
            ->get();
        
        return view('transactions.create', compact('incomeCategories', 'expenseCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);
        
        $validated['user_id'] = Auth::id();
        
        Transaction::create($validated);
        
        return redirect()->route('transactions.index')
            ->with('success', 'Transaction ajoutée avec succès.');
    }

    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);
        
        $user = Auth::user();
        $incomeCategories = Category::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereNull('user_id');
            })
            ->where(function($query) {
                $query->where('type', 'income')
                    ->orWhere('type', 'both');
            })
            ->get();
        
        $expenseCategories = Category::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereNull('user_id');
            })
            ->where(function($query) {
                $query->where('type', 'expense')
                    ->orWhere('type', 'both');
            })
            ->get();
        
        return view('transactions.edit', compact('transaction', 'incomeCategories', 'expenseCategories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);
        
        $validated = $request->validate([
            'type' => 'required|in:income,expense',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);
        
        $transaction->update($validated);
        
        return redirect()->route('transactions.index')
            ->with('success', 'Transaction mise à jour avec succès.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);
        
        $transaction->delete();
        
        return redirect()->route('transactions.index')
            ->with('success', 'Transaction supprimée avec succès.');
    }

    public function export(Request $request)
    {
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)
            ->with('category')
            ->orderBy('date', 'desc')
            ->get();
        
        $format = $request->input('format', 'csv');
        
        if ($format === 'pdf') {
            // Generate PDF using a library like dompdf
            $pdf = \PDF::loadView('transactions.pdf', compact('transactions'));
            return $pdf->download('transactions.pdf');
        } else {
            // Generate CSV
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="transactions.csv"',
            ];
            
            $callback = function() use ($transactions) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Date', 'Type', 'Catégorie', 'Montant', 'Description']);
                
                foreach ($transactions as $transaction) {
                    fputcsv($file, [
                        $transaction->date->format('Y-m-d'),
                        $transaction->type === 'income' ? 'Revenu' : 'Dépense',
                        $transaction->category->name,
                        $transaction->amount,
                        $transaction->description,
                    ]);
                }
                
                fclose($file);
            };
            
            return response()->stream($callback, 200, $headers);
        }
    }
}

