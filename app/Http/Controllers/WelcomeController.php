<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    // Show the homepage
    public function index(){

        return view('welcome');
    }
}

