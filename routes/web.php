<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/* Route::get('/', function () { // Replaced
    return view('welcome');
}); */

/* // CRUD for articles  replaced
Route::resource('articles', ArticleController::class); */

// CRUD Routes that require verification
Route::middleware(['auth', 'verified'])->group(function(){
    Route::resource('articles', ArticleController::class)->except(['index', 'show']);
});

// CRUD Routes not requiring verification
Route::resource('articles', ArticleController::class)->only(['index', 'show']);

// Delete confirmation
Route::get('articles/{article}/delete', [ArticleController::class, 'delete'])
    ->middleware(['auth', 'verified'])->name('articles.delete');

// CRUD for comments
Route::resource('comments', CommentController::class);

// Homepage
Route::get('/', [WelcomeController::class, 'index'])->name('homepage');

// Publish
Route::get('articles/{article}/publish',[ArticleController::class, 'publish'])
    ->middleware(['auth', 'verified'])->name('articles.publish');

// Reject
Route::get('articles/{article}/reject',[ArticleController::class, 'reject'])
    ->middleware(['auth', 'verified'])->name('articles.reject');

// Breeze Dashboard
/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Fallback route
Route::fallback([WelcomeController::class, 'index']); //Fallback route for unknown url  