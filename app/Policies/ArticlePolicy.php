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

    // Only the article's writer can edit an article if it is not published or it is rejected
    public function update(User $user, Article $article){
        return ($user->isOwner($article) && ($article->published_at == NULL || $article->rejected == 1));
    }

    // Only the editor and the writer - the latter when the article is not published
    // can delete an article
    public function delete(User $user, Article $article){

        return ($user->isOwner($article) && $article->published_at == NULL)
        || ($user->hasRole('editor') && $user->email_verified_at !=NULL);
    }

    // Only a verified editor can publish an article
    public function publish(User $user, Article $article){

        return ($user->hasRole('editor') && $user->email_verified_at !=NULL);
    }

    // Only a verified editor can reject an article
    public function reject(User $user, Article $article){

        return ($user->hasRole('editor') && $user->email_verified_at !=NULL);
    }
}
