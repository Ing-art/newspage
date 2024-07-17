<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

/* Route::get('/', function () { // Replaced
    return view('welcome');
}); */



// CRUD for articles
Route::resource('articles', ArticleController::class);

// Delete confirmation
Route::get('articles/{article}/delete', [ArticleController::class, 'delete'])
        ->name('articles.delete');

// CRUD for comments
Route::resource('comments', CommentController::class);

// Homepage
Route::get('/', [WelcomeController::class, 'index'])->name('homepage');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Fallback route
Route::fallback([WelcomeController::class, 'index']); //Fallback route for unknown url  