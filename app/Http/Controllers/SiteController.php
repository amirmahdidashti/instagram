<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
class SiteController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        foreach ($posts as $post) {
            $user = User::find($post->user_id);
            $post->user_avatar = $user->avatar;
            $post->user_id = $user->id;
        }
        return view('index', compact('posts'));
    }
}
