<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //

    public function index(){


    }

    public function __construct(){

    }

    public function create(Request $request){

    }

    public function store(Request $request){

        if(!Auth::check()){
            return redirect()->route('login')->with('error', 'Please log in');
        }

        if($request->user()->cant('create', Comment::class))
            abort(401, 'Unauthorized operation'); 

        $request->validate([
            'text' => 'required|max:255',
            'user_id' => 'required|numeric',
            'article_id' => 'required|numeric'
        ]);
        $currentDateTime = date('Y-m-d H:i:s');
        $comment = new Comment();
        $comment->text = $request->input('text');
        $comment->user_id = $request->user()->id;
        $comment->article_id = $request->input('article_id'); 
        $comment->updated_at = $currentDateTime;

        $comment->save();

        return back()->with('success', 'Your comment has been published');
    }

    public function destroy(Request $request, Comment $comment){

        if(!Auth::check()){
            return redirect()->route('login')->with('error', 'Please log in');           
        }

        if($request->user()->cant('delete', $comment))
            abort(401, 'Unauthorized operation');

        $comment->delete();

        return back()->with('success', 'Comment successfully deleted');
    }
}
