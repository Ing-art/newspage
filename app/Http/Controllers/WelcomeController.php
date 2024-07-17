<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;


class WelcomeController extends Controller
{
    // Show the homepage
    public function index(){

    // return view('welcome');

    $articles = Article::whereNotNull('published_at')->where('isTopNews',0)->orderby('published_at', 'DESC')->paginate(8);
    $total = Article::whereNotNull('published_at')->count();
    $lastItem = $articles->last(); // Get the last item of the current page

    $toparticles = Article::whereNotNull('published_at')->where('isTopNews',1)->get();

        return view('welcome', ['articles' => $articles, 'total' => $total, 'toparticles' => $toparticles, 'lastItem'=>$lastItem]);
    }


    
}

