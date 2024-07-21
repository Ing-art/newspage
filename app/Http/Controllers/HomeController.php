<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index(Request $request){

        $articles = $request->user()->articles()->get();
        $comments = $request->user()->comments()->get();

        return view('dashboard', ['articles' =>$articles, 'commments'=> $comments]);
  
    }
}
