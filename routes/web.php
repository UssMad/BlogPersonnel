<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Visitors + Authenticated)
|--------------------------------------------------------------------------
*/

// Blog Home – published articles with optional category filter
Route::get('/', [ArticleController::class, 'index'])->name('articles.index');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Admin Only)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Dashboard – all articles table
    Route::get('/dashboard', [ArticleController::class, 'dashboard'])->name('dashboard');

    // Article CRUD (create route MUST be above {article} wildcard)
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

// Single article view (MUST be after /articles/create to avoid wildcard conflict)
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

require __DIR__.'/auth.php';