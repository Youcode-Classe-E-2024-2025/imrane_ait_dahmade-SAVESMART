<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\FamilyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Routes protégées
Route::middleware(['auth'])->group(function () {
    // Routes pour le profil utilisateur
    Route::get('/profile', [AuthController::class, 'profile'])->name('auth.profile');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Routes pour la gestion du profil
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes pour les profils multiples
    Route::post('/profiles', [ProfileController::class, 'store'])->name('profiles.store');
    Route::put('/profiles/{profile}', [ProfileController::class, 'updateProfile'])->name('profiles.update');
    Route::delete('/profiles/{profile}', [ProfileController::class, 'destroyProfile'])->name('profiles.destroy');

    // Routes pour la gestion des utilisateurs
    Route::resource('users', UserController::class);

    // Routes pour les transactions
    Route::resource('transactions', TransactionController::class);
    
    // Routes pour les catégories
    Route::resource('categories', CategorieController::class);

    // Routes pour la gestion des familles
    Route::get('/families/create', [FamilyController::class, 'create'])->name('families.create');
    Route::post('/families', [FamilyController::class, 'store'])->name('families.store');
    Route::post('/families/invite', [FamilyController::class, 'invite'])->name('families.invite');
    Route::post('/families/leave', [FamilyController::class, 'leave'])->name('families.leave');
    Route::delete('/families', [FamilyController::class, 'destroy'])->name('families.destroy');

    // Route de débogage temporaire
    Route::get('/debug', function () {
        $user = auth()->user();
        $categories = \App\Models\Categorie::where('user_id', $user->id)->get();
        dd([
            'user_id' => $user->id,
            'categories_count' => $categories->count(),
            'categories' => $categories->toArray()
        ]);
    });
});
