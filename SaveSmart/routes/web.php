<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\FamilyController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Transactions
    Route::resource('transactions', TransactionController::class);
    Route::get('/transactions/export/{format?}', [TransactionController::class, 'export'])->name('transactions.export');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Goals
    Route::resource('goals', GoalController::class);
    Route::post('/goals/{goal}/update-amount', [GoalController::class, 'updateAmount'])->name('goals.updateAmount');
    
    // Familles
    Route::get('/families', [FamilyController::class, 'index'])->name('families.index');
    Route::get('/families/create', [FamilyController::class, 'create'])->name('families.create');
    Route::post('/families', [FamilyController::class, 'store'])->name('families.store');
    Route::get('/families/add-member', [FamilyController::class, 'addMember'])->name('families.add-member');
    Route::post('/families/add-member', [FamilyController::class, 'storeMember'])->name('families.store-member');
    Route::delete('/families/remove-member/{member}', [FamilyController::class, 'removeMember'])->name('families.remove-member');
});

