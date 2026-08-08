<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['headline', 'text', 'subject', 'istopnews', 'image', 'user_id', 'rejected', 'submitted'];

    protected function casts(): array
    {
        return [
            'istopnews' => 'boolean',
            'rejected' => 'boolean',
            'submitted' => 'boolean',
            'published_at' => 'datetime',
        ];
    }


    // Return the writer of the article
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    // Return the comments of the article
    public function comments(){
        return $this->hasMany('\App\Models\Comment');
    }

}
