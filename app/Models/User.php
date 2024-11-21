<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Post;
use App\Models\Comment;
use App\Models\message;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function postComments()
    {
        return $this->belongsToMany(Post::class, 'comments')->withTimestamps()->withPivot('body');
    }

    public function messages()
    {
        return $this->hasMany(message::class);
    }

    public function followers()
    {
        return $this->belongsToMany(user::class, 'followers', 'follower_id' , 'following_id')->withTimestamps();
    }
    
    public function followings()
    {
        return $this->belongsToMany(user::class, 'followers', 'following_id' , 'follower_id')->withTimestamps();
    }

    public function chat_1(){
        return $this->belongsToMany(user::class, 'chats', 'user_1' , 'user_2')->withTimestamps()->withPivot('id');
    }

    public function chat_2(){
        return $this->belongsToMany(user::class, 'chats', 'user_2' , 'user_1')->withTimestamps()->withPivot('id');
    }
}
