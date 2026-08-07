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

    // Writers can edit their own drafts or rejected articles. Verified editors
    // can edit any article, including one that has already been published.
    public function update(User $user, Article $article){
        return ($user->isOwner($article) && ($article->published_at == NULL || $article->rejected == 1))
            || ($user->hasRole('editor') && $user->email_verified_at != NULL);
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

    // Only a verified editor can flag an article as topnews
    public function maketopnews(User $user, Article $article){
        return ($user->hasRole('editor') && $user->email_verified_at !=NULL);
    }

    public function removetopnews(User $user, Article $article){
        return ($user->hasRole('editor') && $user->email_verified_at !=NULL);
    }
}
