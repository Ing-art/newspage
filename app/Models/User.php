<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail; // User must have a verified email
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Return the user's roles
    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }

    // Check if the user has a role
    public function hasRole($rolenames):bool{

        if(!is_array($rolenames))
            $rolenames = [$rolenames];

        foreach($this->roles as $role){
            if(in_array($role->role, $rolenames))
                return true;
        }

        return false;
    }

    // Remaining roles
    public function remainingRoles(){

        $currentRoles = $this->roles; // current user's roles
        $allRoles = Role::all(); // all available roles

        return $allRoles->diff($currentRoles);
    }

    // Check if the user is the writer of an article
    public function isOwner(Article $article):bool{
        return $this->id == $article->user_id;
    }

    // Get the articles of the user
    public function articles(){
        return $this->hasMany('App\Models\Article');
    }

    // Check if the user has written a comment
    public function hasCommented(Comment $comment):bool{
        return $this->id == $comment->user_id;
    }

    // Get the comments of the user
    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }

}
