<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Article;

class ArticlePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    // Only writers can write articles
    public function create(User $user){
        return $user->hasRole('writer');
    }

    // Only the article's writer can edit an article
    public function update(User $user, Article $article){
        return $user->isOwner($article);
    }

    // Only the editor and the writer - when the article is not published
    // can delete an article
    public function delete(User $user, Article $article){
        
        return ($user->isOwner($article) && $article->published_at == NULL)
        || $user->hasRole('editor');
    }
}
