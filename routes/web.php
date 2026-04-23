<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

// Blog Public (visiteurs et connectés)
Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
Route::resource('articles', ArticleController::class)->only(['show']);

// Espace d'administration (connectés uniquement)
Route::middleware('auth')->group(function () {
    // Tableau de bord
    Route::get('/dashboard', [ArticleController::class, 'dashboard'])->name('dashboard');
    
    // CRUD des articles
    Route::resource('articles', ArticleController::class)->except(['index', 'show']);
});

require __DIR__.'/auth.php';
