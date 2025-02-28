<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\CategorieController;

class AuthController extends Controller
{
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
            $request->session()->regenerate();

            // Si un profile_id est fourni, vérifier qu'il appartient à la famille de l'utilisateur
            if ($request->has('profile_id')) {
                $user = Auth::user();
                $profile = Profile::find($request->profile_id);
                
                if (!$profile || $profile->family_id !== $user->family_id) {
                    Auth::logout();
                    return back()->withErrors([
                        'profile_id' => 'Profil invalide.',
                    ]);
                }

                // Stocker le profil actif en session
                session(['active_profile_id' => $profile->id]);
                return redirect()->intended('/dashboard');
            }

            // Récupérer les profils disponibles pour l'utilisateur
            $user = Auth::user();
            $profiles = $user->availableProfiles();

            if ($profiles->isEmpty()) {
                // Si l'utilisateur n'a pas de profils, rediriger vers la création de famille
                return redirect()->route('families.create');
            }

            // Stocker les profils en session et redemander la connexion avec choix du profil
            return back()->with('profiles', $profiles->toArray());
        }

        Log::warning('Failed login attempt', ['email' => $credentials['email']]);
        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    // Afficher le formulaire d'inscription
    public function showRegister()
    {
        return view('auth.register');
    }

    // Gérer l'inscription
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:comptes',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Créer les catégories par défaut pour le nouvel utilisateur
        CategorieController::createDefaultCategories($user->id);

        Log::info('New user registered', ['email' => $validated['email']]);
        Auth::login($user);

        return redirect()->route('families.create')
            ->with('success', 'Compte créé avec succès. Créez maintenant votre famille.');
    }

    // Afficher le profil
    public function profile()
    {
        try {
            return view('profile.show');
        } catch (\Exception $e) {
            Log::error('Profile view error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Une erreur est survenue lors du chargement du profil.');
        }
    }

    // Déconnexion
    public function logout(Request $request)
    {
        try {
            $email = Auth::user()->email;
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Log::info('User logged out', ['email' => $email]);
            return redirect('/')->with('success', 'Déconnexion réussie.');
        } catch (\Exception $e) {
            Log::error('Logout error', ['error' => $e->getMessage()]);
            return redirect('/');
        }
    }

    // Afficher la liste des comptes
    public function listComptes()
    {
        $comptes = User::all();
        return view('auth.comptes', ['comptes' => $comptes]);
    }
}
