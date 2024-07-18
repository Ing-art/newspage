<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['headline', 'text', 'subject', 'istopnews', 'image', 'user_id', 'rejected'];



    // Return the writer of the article
    public function user(){
        return $this->belongsTo('App\Models\User');
    }


}
