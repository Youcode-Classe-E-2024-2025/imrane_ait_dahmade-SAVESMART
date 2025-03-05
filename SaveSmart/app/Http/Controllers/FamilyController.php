<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FamilyController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $family = $user->family;
        $members = $family ? $family->users : collect();

        return view('families.index', compact('family', 'members'));
    }

    public function create()
    {
        return view('families.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $family = Family::create($validated);

        $user = Auth::user();
        $user->family_id = $family->id;
        $user->is_family_admin = true;
        $user->save();

        return redirect()->route('families.index')->with('success', 'Famille créée avec succès.');
    }

    public function addMember()
    {
        return view('families.add-member');
    }

    public function storeMember(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $family = $user->family;

        if (!$family) {
            return redirect()->route('families.index')->with('error', 'Vous devez d\'abord créer une famille.');
        }

        $newMember = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'family_id' => $family->id,
        ]);

        return redirect()->route('families.index')->with('success', 'Membre ajouté avec succès.');
    }

    public function removeMember(User $member)
    {
        $user = Auth::user();

        if (!$user->is_family_admin || $user->family_id !== $member->family_id) {
            return redirect()->route('families.index')->with('error', 'Vous n\'avez pas les droits pour effectuer cette action.');
        }

        $member->family_id = null;
        $member->save();

        return redirect()->route('families.index')->with('success', 'Membre retiré avec succès.');
    }
}

