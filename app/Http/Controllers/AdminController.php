<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    //Get the user's details
    public function userShow(User $user){

        return view('admin.users.show', ['user' =>$user]);

    }
}
