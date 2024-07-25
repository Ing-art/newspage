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

        // For users who have serveral roles
        if($request->user()->hasRole(['writer', 'reader', 'editor'])){

            $comments = [];
            $articlestoreview = [];
            $articles = [];
            $articlesrejected = [];
            $drafts = [];


            if($request->user()->hasRole(['writer'])){

                $articles = $request->user()->articles()->whereNotNull('published_at')->where('rejected',0)->orderby('published_at', 'DESC')->get();
                $articlesrejected = $request->user()->articles()->where('rejected',1)->orderby('updated_at', 'DESC')->get();
                $drafts = $request->user()->articles()->whereNull('published_at')->where('rejected',0)->get();

            }

            if($request->user()->hasRole(['reader'])){
                $articles = $request->user()->articles()->whereNotNull('published_at')->where('rejected',0)->orderby('published_at', 'DESC')->get();
                $articlesrejected = $request->user()->articles()->where('rejected',1)->orderby('updated_at', 'DESC')->get();
                $drafts = $request->user()->articles()->whereNull('published_at')->where('rejected',0)->get();
                $comments = $request->user()->comments()->orderby('created_at', 'DESC')->get();

            }

            if($request->user()->hasRole(['editor'])){

                $articlestoreview = Article::whereNull('published_at')->orWhere('rejected', 1)->get();

            }

            return view('dashboard', ['articles' => $articles, 'articlesrejected' => $articlesrejected, 'drafts' => $drafts, 'comments' => $comments, 'articlestoreview' => $articlestoreview] );

        }

        if($request->user()->hasRole('editor')){

            $articlestoreview = Article::whereNull('published_at')->orWhere('rejected', 1)->get();

            return view('dashboard', ['articlestoreview' => $articlestoreview]);

        }

        if($request->user()->hasRole(['writer', 'reader'])){

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

