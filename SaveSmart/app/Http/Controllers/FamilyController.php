<?php

namespace App\Http\Controllers;

use App\Models\Family;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function create()
    {
        return view('families.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $family = Family::create([
            'name' => $request->name,
            'owner_id' => auth()->id(),
        ]);

        // Mettre à jour l'utilisateur actuel avec le family_id
        auth()->user()->update(['family_id' => $family->id]);

        return redirect()->route('profile.edit')
            ->with('success', 'Compte familial créé avec succès.');
    }

    public function invite(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:comptes,email',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if ($user->family_id) {
            return back()->with('error', 'Cet utilisateur fait déjà partie d\'une famille.');
        }

        $user->update(['family_id' => auth()->user()->family_id]);

        return back()->with('success', 'Membre ajouté à la famille avec succès.');
    }

    public function leave()
    {
        $user = auth()->user();
        
        if ($user->isOwnerOfFamily()) {
            return back()->with('error', 'Le propriétaire ne peut pas quitter la famille. Supprimez la famille ou transférez la propriété.');
        }

        $user->update(['family_id' => null]);

        return redirect()->route('profile.edit')
            ->with('success', 'Vous avez quitté le compte familial.');
    }

    public function destroy()
    {
        $user = auth()->user();
        
        if (!$user->isOwnerOfFamily()) {
            return back()->with('error', 'Seul le propriétaire peut supprimer la famille.');
        }

        $user->ownedFamily->delete();

        return redirect()->route('profile.edit')
            ->with('success', 'Compte familial supprimé avec succès.');
    }
}
