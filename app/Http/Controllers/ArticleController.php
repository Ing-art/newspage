<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;

class ArticleController extends Controller
{

    public function index()
    {

        $articles = Article::orderby('id', 'DESC')->paginate(9);

        return view('articles.list', ['articles' => $articles]);
    }

    public function __construct()
    {

/*         $this->middleware('verified')->except('index', 'show', 'search');

           $this->middleware('password.confirm')->only('destroy','create');

           $this->middleware('throttle:3,1')->only('delete');  // For testing throttle  */
    }

    public function create(Request $request)
    {    
        if(!Auth::check()){
            return redirect()->route('login')->with('error', 'Please log in');
        }

        if($request->user()->cant('create', Article::class))
            abort(401, 'You have not permission. You are not a writer'); //TODO Check

        // Subjects for the select
        $subjects = [
            'Culture',
            'Economy',
            'Environment',
            'Entertainment',
            'Health',
            'Politics',
            'Science',
            'Society',
            'Sports',
            'Technology'
        ];

        // Show the form
        return view('articles.create', ['subjects' => $subjects]);
    }

    public function store(Request $request)
    {

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
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store(config('filesystems.articlesImageDir'), 'public');
            $article->image = pathinfo($path, PATHINFO_BASENAME);
        } else {
            $article->image = $request->input('image') ?? NULL;
        }

        // Save the new article with the data from POST
        $article->save();

        return redirect()->route('homepage')
            ->with('success', 'Your article has been saved');
    }

    public function show(Article $article)
    {

        return view('articles.show', ['article' => $article]); //Make sure the @auth are put in the relevant protected sections
    }

    public function edit(Request $request, Article $article)
    {
        if(!Auth::check()){
            return redirect()->route('login')->with('error', 'Please log in');
        }

        if($request->user()->cant('update',$article))
            abort(401, 'You have not permission. The article is not yours');

        // Subjects for the select
        $subjects = [
            'Culture',
            'Economy',
            'Environment',
            'Entertainment',
            'Health',
            'Politics',
            'Science',
            'Society',
            'Sports',
            'Technology'
        ];

        return view('articles.update', ['article' => $article, 'subjects'=>$subjects]);
    }

    public function update(Request $request, Article $article)
    {
        if(!Auth::check()){
            return redirect()->route('login')->with('error', 'Please log in');
        }

        if($request->user()->cant('update',$article))
            abort(401, 'You have not permission. The article is not yours');

        $request->validate([
            'headline' => 'required|max:255',
            'text' => 'required',
            'subject' => 'required|max:40',
            'istopnews' => 'sometimes|number',
            'image' => 'nullable|file|image|mimes:jpg,jpeg,png,gif,webp|max:5000',
            'rejected' => 'sometimes|number'
        ]);

        $article->headline = $request->input('headline');
        $article->subject = $request->input('subject');
        $article->text = $request->input('text');

        if($request->hasFile('image')){
            // Upload the new image to the defined directory
            $pathNewImage = $request->file('image')
            ->store(config('filesystems.articlesImageDir'), 'public');

            // Delete the old image if it exists
            if($article->image){
                $toDelete = config('filesystems.articlesImageDir').'/'.$article->image;
                Storage::delete($toDelete); // Delete the old image      
            }

            // Update the article's image in the database
            $article->image = pathinfo($pathNewImage, PATHINFO_BASENAME);
                    
        }else{  // If something goes wrong
            if(isset($pathNewImage))
                Storage::delete($pathNewImage); // Delete new image
        };

        $article->save();

        return redirect()->route('articles.show', $article->id)
            ->with('success', "Article successfuly updated");
    }

    public function delete(Article $article)
    {
        if(!Auth::check()){
            return redirect()->route('login')->with('error', 'Please log in');
        }
        return view('articles.delete', ['article' => $article]);
    }

    public function destroy(Request $request, Article $article)
    {
        if(!Auth::check()){
            return redirect()->route('login')->with('error', 'Please log in');
        }

        $article->delete();

        return redirect('homepage')
            ->with('success', "Article successfully deleted");
    }

    public function publish (Request $request, Article $article){

        if(!Auth::check()){
            return redirect()->route('login')->with('error', 'Please log in');
        }

        if($request->user()->cant('publish',$article))
            abort(401, 'You have not permission. You are not an editor');

        if($article){

            $article->touch('published_at'); // Update the published_at value to now
            $article->rejected = 0;
            $article->save();

            return back()->with('success', 'The article is now live!');
        }
        return back()->with('message', 'something went wrong');
    }

    public function reject(Request $request, Article $article){

        if(!Auth::check()){
            return redirect()->route('login')->with('error', 'Please log in'); //FIXME login layout
        }

        if($request->user()->cant('reject',$article))
            abort(401, 'You have not permission. You are not an editor');

        if($article){

            $article->rejected = 1;
            $article->save();

            return back()->with('success', 'The article has been flagged as rejected');
        }

        return back()->with('message', 'something went wrong');
    }
}

