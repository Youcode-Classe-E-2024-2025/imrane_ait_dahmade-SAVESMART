<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function index(): View
    {
        $profiles = auth()->user()->availableProfiles();
        return view('profiles.index', compact('profiles'));
    }

    public function edit(): View
    {
        $user = Auth::user();
        $profiles = $user->availableProfiles();
        return view('profile.edit', compact('profiles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7'
        ]);

        if (!auth()->user()->family_id) {
            return back()->with('error', 'Vous devez d\'abord créer ou rejoindre une famille.');
        }

        Profile::create([
            'name' => $request->name,
            'color' => $request->color,
            'family_id' => auth()->user()->family_id
        ]);

        return back()->with('success', 'Profil créé avec succès.');
    }

    public function update(Request $request, Profile $profile): RedirectResponse
    {
        $this->authorize('update', $profile);

        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7'
        ]);

        $profile->update($request->only(['name', 'color']));

        return back()->with('success', 'Profil mis à jour avec succès.');
    }

    public function destroy(Profile $profile): RedirectResponse
    {
        $this->authorize('delete', $profile);

        if ($profile->transactions()->exists()) {
            return back()->with('error', 'Ce profil ne peut pas être supprimé car il contient des transactions.');
        }

        $profile->delete();

        return back()->with('success', 'Profil supprimé avec succès.');
    }
}
