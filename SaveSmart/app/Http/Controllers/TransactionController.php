<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('categorie')
            ->where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->get();

        // Calculer les totaux
        $revenus = $transactions->where('type', 'revenu')->sum('montant');
        $depenses = $transactions->where('type', 'depense')->sum('montant');
        $solde = $revenus - $depenses;

        return view('transactions.index', compact('transactions', 'revenus', 'depenses', 'solde'));
    }

    public function create()
    {
    
        $categories = Categorie::where('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        // Si l'utilisateur n'a pas de catégories, créer les catégories par défaut
        if ($categories->isEmpty()) {
            $this->createDefaultCategories(Auth::id());
            $categories = Categorie::where('user_id', Auth::id())
                ->orderBy('name')
                ->get();
        }

        // Log pour déboguer
        Log::info('Catégories trouvées:', [
            'user_id' => Auth::id(),
            'count' => $categories->count(),
            'categories' => $categories->toArray()
        ]);

        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:revenu,depense',
            'montant' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'categorie_id' => 'required|exists:categories,id'
        ]);

        // Vérifier que la catégorie appartient bien à l'utilisateur
        $categorie = Categorie::findOrFail($validated['categorie_id']);
        if ($categorie->user_id !== Auth::id()) {
            return back()->with('error', 'Catégorie invalide.');
        }

        $validated['user_id'] = Auth::id();

        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction créée avec succès.');
    }

    public function edit(Transaction $transaction)
    {
        $this->authorize('update', $transaction);
        $categories = Categorie::where('user_id', Auth::id())->get();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $validated = $request->validate([
            'type' => 'required|in:revenu,depense',
            'montant' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'categorie_id' => 'required|exists:categories,id'
        ]);

        // Vérifier que la catégorie appartient bien à l'utilisateur
        $categorie = Categorie::findOrFail($validated['categorie_id']);
        if ($categorie->user_id !== Auth::id()) {
            return back()->with('error', 'Catégorie invalide.');
        }

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

    private function createDefaultCategories($userId)
    {
        $categories = [
            // Dépenses
            ['name' => 'Alimentation', 'type' => 'depense', 'color' => '#FF5733', 'icon' => '🍽️'],
            ['name' => 'Transport', 'type' => 'depense', 'color' => '#33FF57', 'icon' => '🚗'],
            ['name' => 'Logement', 'type' => 'depense', 'color' => '#3357FF', 'icon' => '🏠'],
            ['name' => 'Factures', 'type' => 'depense', 'color' => '#FF33F5', 'icon' => '📄'],
            ['name' => 'Santé', 'type' => 'depense', 'color' => '#33FFF5', 'icon' => '🏥'],
            ['name' => 'Loisirs', 'type' => 'depense', 'color' => '#F5FF33', 'icon' => '🎮'],
            ['name' => 'Shopping', 'type' => 'depense', 'color' => '#FF3333', 'icon' => '🛍️'],
            ['name' => 'Education', 'type' => 'depense', 'color' => '#33FFB5', 'icon' => '📚'],
            
            // Revenus
            ['name' => 'Salaire', 'type' => 'revenu', 'color' => '#33FF57', 'icon' => '💰'],
            ['name' => 'Freelance', 'type' => 'revenu', 'color' => '#5733FF', 'icon' => '💻'],
            ['name' => 'Investissements', 'type' => 'revenu', 'color' => '#FFB533', 'icon' => '📈'],
            ['name' => 'Cadeaux', 'type' => 'revenu', 'color' => '#FF33A1', 'icon' => '🎁'],
        ];

        foreach ($categories as $category) {
            Categorie::create([
                'name' => $category['name'],
                'type' => $category['type'],
                'color' => $category['color'],
                'icon' => $category['icon'],
                'user_id' => $userId
            ]);
        }
    }
}
