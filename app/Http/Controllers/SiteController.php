<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Auth;
use Validator;
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
    public function newpost()
    {
        return view('newpost');
    }
    public function newpostPost(Request $req)
    {
        $message = [
            'title.required' => 'عنوان نباید خالی باشد',
            'title.min' => 'عنوان باید حداقل 5 کاراکتر باشد',
            'body.required' => 'متن نباید خالی باشد',
            'body.min' => 'متن باید حداقل 10 کاراکتر باشد',
            'image.required' => 'عکس نباید خالی باشد',
            'image.mimes' => 'فرمت عکس باید jpeg, jpg, png, gif, svg باشد',
            'image.max' => 'حجم عکس باید حداکثر 5 مگابایت باشد',
        ];
        $roles = [
            'title' => 'required|min:5',
            'body' => 'required|min:10',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ];
        $validator = Validator::make($req->all(), $roles, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }
        $user = Auth::user();
        $post = new Post();
        $post->user_id = $user->id;
        $post->title = $req->title;
        $post->body = $req->body;
        $img = $req->file('image');
        $imgName = time().".".$img->getClientOriginalExtension();
        $img->move('files/posts/',$imgName);
        $post->image = 'files/posts/'.$imgName;
        $post->save();
        return redirect('/');
    }
}
