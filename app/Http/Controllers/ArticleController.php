<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
 
    // Show the article
    public function show(Article $article){
        return view('articles.show', ['article' => $article]);  
    }

    // Load the edit form
    public function edit(Article $article){
        return view('articles.update', ['article'=> $article]);
    }
}
