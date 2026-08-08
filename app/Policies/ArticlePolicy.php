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

    // Only the writer who owns an editable draft or rejected article can edit it.
    public function update(User $user, Article $article){
        return $user->hasRole('writer')
            && $user->isOwner($article)
            && $article->published_at === null
            && !$article->submitted;
    }

    // Only the writer who owns an editable draft or rejected article can delete it.
    public function delete(User $user, Article $article){
        return $user->hasRole('writer')
            && $user->isOwner($article)
            && $article->published_at === null
            && !$article->submitted;
    }

    // Only the writer who owns an editable draft or rejected article can submit it.
    public function submit(User $user, Article $article){
        return $user->hasRole('writer')
            && $user->isOwner($article)
            && $article->published_at === null
            && !$article->submitted;
    }

    // Only a verified editor can publish an article
    public function publish(User $user, Article $article){

        return $user->hasRole('editor')
            && $user->email_verified_at !== null
            && $article->submitted
            && $article->published_at === null
            && !$article->rejected;
    }

    // Only a verified editor can return a published article to draft status.
    public function unpublish(User $user, Article $article){
        return $user->hasRole('editor')
            && $user->email_verified_at !== null
            && $article->published_at !== null;
    }

    // Only a verified editor can reject an article
    public function reject(User $user, Article $article){

        return $user->hasRole('editor')
            && $user->email_verified_at !== null
            && $article->submitted
            && $article->published_at === null
            && !$article->rejected;
    }

    // Only a verified editor can flag an article as topnews
    public function maketopnews(User $user, Article $article){
        return ($user->hasRole('editor') && $user->email_verified_at !=NULL);
    }

    public function removetopnews(User $user, Article $article){
        return ($user->hasRole('editor') && $user->email_verified_at !=NULL);
    }
}
