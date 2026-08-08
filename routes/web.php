<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;

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

// Submit a draft or rejected article for editorial review
Route::patch('articles/{article}/submit', [ArticleController::class, 'submit'])
    ->middleware(['auth', 'verified'])->name('articles.submit');

// Publish
Route::patch('articles/{article}/publish',[ArticleController::class, 'publish'])
    ->middleware(['auth', 'verified'])->name('articles.publish');

// Return a published article to its writer as a draft
Route::patch('articles/{article}/unpublish', [ArticleController::class, 'unpublish'])
    ->middleware(['auth', 'verified'])->name('articles.unpublish');

// Reject
Route::patch('articles/{article}/reject',[ArticleController::class, 'reject'])
    ->middleware(['auth', 'verified'])->name('articles.reject');

// Make Top News
Route::patch('articles/{article}/maketopnews', [ArticleController::class, 'maketopnews'])
    ->middleware(['auth', 'verified'])->name('articles.maketopnews');

// Remove from Top News
Route::patch('articles/{article}/removetopnews', [ArticleController::class, 'removetopnews'])
    ->middleware(['auth', 'verified'])->name('articles.removetopnews');

// Original Breeze Dashboard Route
/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard'); */

// For admin users - single route
/* Route::get('user/{user}/details', [AdminController::class, 'userShow'])
->middleware('is_admin')->name('admin.users.show'); */


Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('is_admin')->group(function(){
    Route::get('user/{user}/details',[AdminController::class, 'userShow'])->name('admin.users.show');
    Route::post('role', [AdminController::class, 'setrole'])->name('admin.user.setrole');
    Route::delete('role', [AdminController::class, 'removerole'])->name('admin.user.removerole');
});

// Contact Form
Route::get('/contact', [ContactController::class, 'index'])->name('contact');

// Send Email from contact form
Route::post('/contact', [ContactController::class, 'send'])->name('contact.mail');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Blocked users

Route::get('/blocked', [UserController::class, 'blocked'])->name('blocked');

require __DIR__.'/auth.php';

// Fallback route
Route::fallback([WelcomeController::class, 'index']); //Fallback route for unknown url
