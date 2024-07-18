<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
 
    public function create(){
        // Show the form
        return view('articles.create');
    }

    public function store(Request $request){

        $request->validate([
            'headline' => 'required|max:255',
            'text' => 'required',
            'subject' => 'required|max:40',
            'istopnews' => 'sometimes|number',
            'image' => 'sometimes|file|image|mimes:jpg,jpeg,png,gif,webp|max:5000',
            'rejected' => 'sometimes|number'
        ]);  

        $currentDateTime = date('Y-m-d H:i:s');
        $article = new Article();
        
        $article->headline = $request->input('headline');
        $article->subject = $request->input('subject');
        $article->text = $request->input('text');
        $article->user_id = $request->user()->id;
        $article->updated_at = $currentDateTime;

        // We get the path where the image is stored and the filename
        if($request->hasFile('image')){
            $path = $request->file('image')->store(config('filesystems.articlesImageDir'));
            $article->image = pathinfo($path, PATHINFO_BASENAME);
        }else{
            $article->image = $request->input('image') ?? NULL;
        }

        // Save the new article with the data from POST
        $article->save();
           
        return redirect()->route('homepage')
            ->with('success', 'Your article has been saved');
    }

    public function show($id){

        $article = Article::findOrFail($id);

        return view('articles.show', ['article'=>$article]);
    }

    public function edit($id){

        $article = Article::findOrFail($id);

        return view('articles.update', ['article'=>$article]);
    }

    public function update(Request $request, $id){

        $request->validate([
            'headline' => 'required|max:255',
            'text' => 'required',
            'subject' => 'required|max:40',
            'istopnews' => 'sometimes|number',
            'image' => 'sometimes|file|image|mimes:jpg,jpeg,png,gif,webp|max:5000',
            'rejected' => 'sometimes|number'
        ]);   

        $article = Article::findOrFail($id);
        $article->update($request->all());

        return back()->with('success', "Article successfuly updated");     
    }

    public function delete($id){

        $article = Article::findOrFail($id);

        return view('articles.delete', ['article'=>$article]);
    }

    public function destroy($id){

        $article = Article::findOrFail($id);

        $article->delete();

        return redirect('homepage')
            ->with('success', "Article successfully deleted");
    }
}
