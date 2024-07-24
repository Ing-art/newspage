<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //List all articles
        $articles = Article::orderby('created_at', 'DESC')->get();

        return [
            'status' => 'OK',
            'total' => count($articles),
            'results' => $articles
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->json()->all();
        $data['image'] = NULL;
        $data['user_id'] = 11; // Unknown user

        $article = Article::create($data);

        return $article ?
            response([
                'status' => 'OK',
                'results' => [$article]
            ], 201) :
            response([
                'status' => 'ERROR',
                'message' => 'The article could not be saved'
            ], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Shows an article
        $article = Article::find($id);

        return $article ? [
            'status' => 'OK',
            'results' => [$article]
        ] :
        response(['status' => 'NOT FOUND'],404);
    }

    public function search(string $field = 'headline', string $value = '')
    {
        // Search an article by keyword
        $articles = Article::where($field, 'LIKE', "%$value%")->get();

        return [
            'status' => 'OK',
            'total' => count($articles),
            'results' => [$articles]
        ];

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Update an article
        $article = Article::find($id); // get the article

        if(!$article)
            return response(['status' => 'NOT FOUND'], 404);

        $data = $request->json()->all();

        return $article->update($data) ?
            response([
                'status' => 'OK',
                'results' => [$article]
            ], 200) :
            response([
                'status' => 'ERROR',
                'message' => 'The article could not be updated'
            ], 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete($id){

        $article = Article::find($id);

        if(!$article)
            return response(['status' => 'NOT FOUND'], 404);

        return $article->delete() ?
            response(['status' => 'OK']) :
            response(['status' => 'ERROR',
            'message' => 'The articel could not be deleted'], 400);
    }
}

