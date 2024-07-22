<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'user_id', 'article_id', 'updated_at'];

    // Get the user who posted the comment
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    // Get the article where the comment belogs
    public function article(){
        return $this->belongsTo('App\Models\Article');
    }

}
