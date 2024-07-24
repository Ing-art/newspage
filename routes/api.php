<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// List all articles
Route::get(
    'articles',
    [ArticleController::class, 'index']
);


// Get an article by its id
Route::get(
    '/article/{article}',
    [ArticleController::class, 'show']
)->where('article', '^\d+$');


// Find an article by keyword in title, text, subject
Route::get(
    '/articles/{field}/{value}',
    [ArticleController::class, 'search']
)->where('field', '^headline|text|subject$');


// Create a mew article
Route::post(
    '/article',
    [ArticleController::class, 'store']
);


// Update an article
Route::put(
    '/article/{article}',
    [ArticleController::class, 'update']
);


// Delete an article
Route::delete(
    '/article/{article}',
    [ArticleController::class, 'delete']
);

// Fallback route
Route::fallback(function(){
    return response(['status' => 'BAD REQUEST'], 400);
});
