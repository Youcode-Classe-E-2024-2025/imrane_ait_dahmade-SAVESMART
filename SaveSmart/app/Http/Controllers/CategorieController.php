<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::where('user_id', Auth::id())
            ->withCount('transactions')
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:revenu,depense',
            'couleur' => 'required|string|max:7'
        ]);

        $validated['user_id'] = Auth::id();

        Categorie::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie créée avec succès.');
    }

    public function edit(Categorie $categorie)
    {
        $this->authorize('update', $categorie);
        return view('categories.edit', compact('categorie'));
    }

    public function update(Request $request, Categorie $categorie)
    {
        $this->authorize('update', $categorie);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:revenu,depense',
            'couleur' => 'required|string|max:7'
        ]);

        $categorie->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie mise à jour avec succès.');
    }

    public function destroy(Categorie $categorie)
    {
        $this->authorize('delete', $categorie);

        if ($categorie->transactions()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Impossible de supprimer une catégorie qui contient des transactions.');
        }

        $categorie->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie supprimée avec succès.');
    }

    // Méthode pour créer les catégories par défaut pour un utilisateur
    public static function createDefaultCategories($userId)
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
