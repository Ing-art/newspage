<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // Load the view for blocked users
    public function blocked(){

        return view('blocked');
    }
}
