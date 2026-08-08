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

        $user = $request->user();
        $dashboard = [
            'articles' => collect(),
            'articlesrejected' => collect(),
            'drafts' => collect(),
            'submittedarticles' => collect(),
            'comments' => collect(),
            'articlestoreview' => collect(),
            'users' => collect(),
        ];

        if ($user->hasRole('writer')) {
            $dashboard['articles'] = $user->articles()
                ->whereNotNull('published_at')
                ->where('rejected', 0)
                ->orderBy('published_at', 'DESC')
                ->get();
            $dashboard['articlesrejected'] = $user->articles()
                ->whereNull('published_at')
                ->where('rejected', 1)
                ->where('submitted', 0)
                ->orderBy('updated_at', 'DESC')
                ->get();
            $dashboard['drafts'] = $user->articles()
                ->whereNull('published_at')
                ->where('rejected', 0)
                ->where('submitted', 0)
                ->orderBy('updated_at', 'DESC')
                ->get();
            $dashboard['submittedarticles'] = $user->articles()
                ->whereNull('published_at')
                ->where('rejected', 0)
                ->where('submitted', 1)
                ->orderBy('updated_at', 'DESC')
                ->get();
        }

        if ($user->hasRole('reader')) {
            $dashboard['comments'] = $user->comments()
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        if ($user->hasRole('editor')) {
            $dashboard['articlestoreview'] = Article::where('rejected', 0)
                ->where(function ($query) {
                    $query->where(function ($pending) {
                        $pending->whereNull('published_at')
                            ->where('submitted', 1);
                    })->orWhereNotNull('published_at');
                })
                ->orderBy('updated_at', 'DESC')
                ->get();
        }

        if ($user->hasRole('admin')) {
            $dashboard['users'] = User::orderBy('created_at', 'DESC')->get();
        }

        return view('dashboard', $dashboard);
    }
}
