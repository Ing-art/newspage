<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

use App\Models\User;

class HomeController extends Controller
{
    //

    public function index(Request $request){

        if($request->user()->hasRole('writer')){


            $articles = $request->user()->articles()->whereNotNull('published_at')->where('rejected',0)->orderby('published_at', 'DESC')->get();
            $articlesrejected = $request->user()->articles()->where('rejected',1)->orderby('updated_at', 'DESC')->get();
            $drafts = $request->user()->articles()->whereNull('published_at')->get();



            return view('dashboard', ['articles' => $articles, 'articlesrejected' => $articlesrejected, 'drafts' => $drafts] );

        }

        if($request->user()->hasRole('editor')){

            $articlestoreview = Article::whereNull('published_at')->get();
            $articlesrejected = Article::where('rejected',1)->get();

            return view('dashboard', ['articlestoreview' => $articlestoreview, 'articlesrejected'=>$articlesrejected]);

        }

        if($request->user()->hasRole('reader')){

            $comments = $request->user()->comments()->orderby('created_at', 'DESC')->get();
            // dd($comments);
            return view('dashboard', ['comments'=> $comments]);

        }

        if($request->user()->hasRole('admin')){

            $users = User::orderby('created_at', 'DESC')->get();

            return view('dashboard', ['users' =>$users]);

        }
    }
}

