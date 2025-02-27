<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Afficher le formulaire d'inscription
    public function showRegister()
    {
        return view('auth.register');
    }

    // Gérer l'inscription
    public function register(Request $request)
    {
        $request->validate([
    
            'email' => 'required|string|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Compte::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Inscription réussie, vous pouvez vous connecter.');
    }

    // Afficher le formulaire de connexion
    public function showLogin()
    {
        return view('auth.login');
    }

    // Gérer la connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('profile.show')->with('success', 'Connexion réussie.');
        }

        return back()->withErrors(['email' => 'Identifiants incorrects.']);
    }

    // Déconnexion
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Déconnexion réussie.');
    }
}
