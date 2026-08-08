<?php

namespace App\Http\Controllers;

use App\Events\ArticlePublished;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;
use App\Events\ArticleRejected;

class ArticleController extends Controller
{

    public function index()
    {

        $articles = Article::orderby('id', 'DESC')->paginate(9);

        return view('articles.list', ['articles' => $articles]);
    }

    public function __construct()
    {

    }

    public function create(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in');
        }

        if ($request->user()->cant('create', Article::class))
            abort(401, 'Unauthorized operation. You are not a writer');

        // If the user has been blocked
        if ($request->user()->hasRole('blocked')) {
            return redirect()->route('blocked');
        }

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


        // Get the path where the image is stored and the filename
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store(config('filesystems.articlesImageDir'), 'public');
            $article->image = pathinfo($path, PATHINFO_BASENAME);
        } else {
            $article->image = $request->input('image') ?? NULL;
        }

        // Save the new article with the data from POST
        $article->save();

        return redirect()->route('dashboard')
            ->with('success', 'Your article has been saved');
    }

    public function show(Article $article)
    {

        // Blocks the view if the article is rejected or has not been authorized by the editor
        if ($article->rejected == 1 || $article->published_at == NULL) {
            if (!Auth::check()) {
                return redirect()->route('login')->with('error', 'Please log in');
            }

            $editorCanReview = Auth::user()->hasRole('editor')
                && Auth::user()->email_verified_at !== null
                && $article->submitted
                && !$article->rejected;

            if (!Auth::user()->isOwner($article) && !$editorCanReview) {
                abort(401, 'Article is not available');
            }

        }

        // Increment Visits
        $viewed = Session::get('viewed_article', []);
        if (!in_array($article->id, $viewed)) {
            $article->increment('visits');
            Session::push('viewed_article', $article->id);
        }

        // Get the comments related to the article (relationship hasMany)
        $comments = $article->comments()->orderby('created_at', 'ASC')->get();
        //  dd($comments);
        return view('articles.show', ['article' => $article, 'comments' => $comments]);
    }

    public function edit(Request $request, Article $article)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in');
        }

        if ($request->user()->cant('update', $article))
            abort(401, 'Unauthorized operation');

        // If the user has been blocked
        if ($request->user()->hasRole('blocked')) {
            return redirect()->route('blocked');
        }

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

        return view('articles.update', ['article' => $article, 'subjects' => $subjects]);
    }

    public function update(Request $request, Article $article)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in');
        }

        if ($request->user()->cant('update', $article))
            abort(401, 'Unauthorized operation');

        // If the user has been blocked
        if ($request->user()->hasRole('blocked')) {
            return redirect()->route('blocked');
        }

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

        if ($request->hasFile('image')) {
            // Upload the new image to the defined directory
            $pathNewImage = $request->file('image')
                ->store(config('filesystems.articlesImageDir'), 'public');

            // Delete the old image if it exists
            if ($article->image) {
                $toDelete = config('filesystems.articlesImageDir') . '/' . $article->image;
                Storage::delete($toDelete); // Delete the old image
            }

            // Update the article's image in the database
            $article->image = pathinfo($pathNewImage, PATHINFO_BASENAME);

        } else {  // If something goes wrong
            if (isset($pathNewImage))
                Storage::delete($pathNewImage); // Delete new image
        }
        ;

        $article->save();

        return redirect()->route('dashboard')
            ->with('success', "Article successfuly updated");
    }

    public function delete(Request $request, Article $article)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in');
        }

        if ($request->user()->cant('delete', $article))
            abort(401, 'Unauthorized operation');


        // If the user has been blocked
        if ($request->user()->hasRole('blocked')) {
            return redirect()->route('blocked');
        }

        // Remember the current user's url
        Session::put('returnTo', URL::previous());


        return view('articles.delete', ['article' => $article]);
    }

    public function destroy(Request $request, Article $article)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in');
        }

        if ($request->user()->cant('delete', $article))
            abort(401, 'Unauthorized operation');

        // If the user has been blocked
        if ($request->user()->hasRole('blocked')) {
            return redirect()->route('blocked');
        }


        if ($article->delete() && $article->image) {
            Storage::delete(config('filesystems.articlesImageDir') . '/' . $article->image); // Delete the image
        }

/*         return redirect('homepage')
            ->with('success', "Article successfully deleted"); */

            $redirect = Session::has('returnTo') ?
                redirect(Session::get('returnTo')) :
                redirect()->route('dasboard');
            Session::remove('returnTo');  //delete the session variable

            return $redirect->with('success', 'Article successfuly deleted');
    }

    public function publish(Request $request, Article $article)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in');
        }

        if ($request->user()->cant('publish', $article))
            abort(401, 'Unauthorized operation. You are not an editor');

        // If the user has been blocked
        if ($request->user()->hasRole('blocked')) {
            return redirect()->route('blocked');
        }

        // Repeated requests must not publish or notify twice.
        if ($article->published_at !== null && $article->rejected == 0) {
            return back()->with('success', 'The article is already live.');
        }

        if ($article) {

            $article->touch('published_at'); // Update the published_at value to now
            $article->rejected = 0;
            $article->submitted = 0;
            $article->save();

            ArticlePublished::dispatch($article);


            return back()->with('success', 'The article is now live!');
        }
        return back()->with('message', 'something went wrong');
    }

    public function unpublish(Request $request, Article $article)
    {
        if ($request->user()->cant('unpublish', $article)) {
            abort(401, 'Unauthorized operation. You are not an editor');
        }

        if ($request->user()->hasRole('blocked')) {
            return redirect()->route('blocked');
        }

        if ($article->published_at === null) {
            return back()->with('success', 'The article is already a draft.');
        }

        $article->published_at = null;
        $article->istopnews = 0;
        $article->rejected = 0;
        $article->submitted = 0;
        $article->save();

        return back()->with('success', 'The article has been returned to its writer as a draft.');
    }

    public function reject(Request $request, Article $article)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in'); //FIXME login layout
        }

        if ($request->user()->cant('reject', $article))
            abort(401, 'Unauthorized operation. You are not an editor');

        // If the user has been blocked
        if ($request->user()->hasRole('blocked')) {
            return redirect()->route('blocked');
        }

        // Repeated requests must not reject or notify twice.
        if ($article->rejected == 1) {
            return back()->with('success', 'The article is already rejected.');
        }

        if ($article) {

            $article->rejected = 1;
            $article->submitted = 0;
            $article->published_at = null;
            $article->istopnews = 0;
            $article->save();

            ArticleRejected::dispatch($article);

            return back()->with('success', 'The article has been flagged as rejected');
        }

        return back()->with('message', 'something went wrong');
    }

    public function submit(Request $request, Article $article)
    {
        if ($request->user()->cant('submit', $article)) {
            abort(401, 'Only the writer can submit an editable article.');
        }

        if ($request->user()->hasRole('blocked')) {
            return redirect()->route('blocked');
        }

        $article->submitted = 1;
        $article->rejected = 0;
        $article->save();

        return back()->with('success', 'The article has been submitted for editorial review.');
    }

    public function maketopnews(Request $request, Article $article)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in'); 
        }

        if ($request->user()->cant('maketopnews', $article))
            abort(401, 'Unauthorized operation. You are not an editor');

        // If the user has been blocked
        if ($request->user()->hasRole('blocked')) {
            return redirect()->route('blocked');
        }

        if ($article->published_at === null) {
            return back()->withErrors('Only published articles can be marked as top news.');
        }

        if ($article->istopnews == 1) {
            return back()->with('success', 'The article is already top news.');
        }

        $article->istopnews = 1;
        $article->save();

        return back()->with('success', 'The article has been flagged as top news');
         
    }

    public function removetopnews(Request $request, Article $article)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in'); 
        }

        if ($request->user()->cant('removetopnews', $article))
            abort(401, 'Unauthorized operation. You are not an editor');

        // If the user has been blocked
        if ($request->user()->hasRole('blocked')) {
            return redirect()->route('blocked');
        }

        if ($article->istopnews == 0) {
            return back()->with('success', 'The article is not top news.');
        }

        $article->istopnews = 0;
        $article->save();

        return back()->with('success', 'The article has been removed from news');
         
    }


}
