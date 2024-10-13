<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Auth;
use Validator;
use Hash;
class SiteController extends Controller
{
    public function index(request $req)
    {
        
        if ($req->user != null) {
            $posts = Post::where('user_id', $req->user)->get();
        }
        elseif($req->mf== 1) {
            $posts = Post::where('user_id', 2)->get();
        }
        elseif($req->page != null) {
            $posts = Post::all()->skip(($req->page -1)* 10)->take(10);
        }
        else {
            $posts = Post::all()->take(10);
            
        }
        foreach ($posts as $post) {
            $user = User::find($post->user_id);
            $post->user_avatar = $user->avatar;
            $post->user_id = $user->id;
        }
        $posts->nextpage = $req->page + 1;
        if ($req->page == null) {
            $posts->nextpage = 2;
        }
        if(!isset($posts[0])) {
            abort(404);
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
    public function delete($id)
    {
        if (!Post::find($id)) {
            return abort(404);
        }
        if (Auth::user()->id == Post::find($id)->user_id || Auth::user()->email == 'amirdashti264@gmail.com') {
            $post = Post::find($id);
            $post->delete();
            return redirect('/');
        }
        return abort(403);
    }
    public function profile($id = null)
    {
        if ($id){
            $user = User::find($id);
        }
        else{
            $user = Auth::user();
        }
        if (!$user) {
            return abort(404);
        }
        return view('profile', compact('user'));
    }
    public function profilePost(Request $req){
        $message = [
            'name.required' => 'نام نباید خالی باشد',
            'email.required' => 'ایمیل نباید خالی باشد',
            'email.email' => 'فرمت ایمیل اشتباه است',
            'email.unique' => 'ایمیل تکراری است',
            'new_password.min' => 'رمز عبور باید حداقل 8 کاراکتر باشد',
            'avatar.mimes' => 'فرمت عکس باید jpeg, jpg, png, gif باشد',
            'avatar.max' => 'حجم عکس باید حداکثر 2 مگابایت باشد',
        ];
        $roles = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'password' => 'nullable',
            'new_password' => 'nullable|min:8',
            'avatar' => 'nullable|mimes:jpeg,jpg,png,gif|max:2048',
        ];
        $validator = Validator::make($req->all(), $roles, $message);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }
        $user = Auth::user();
        $user->name = $req->name;
        if (strtolower( trim( $req->email )) != $user->email) {
            $user->avatar = 'https://www.gravatar.com/avatar/'.hash( 'sha256', strtolower( trim( $req->email ) )).'?d=mp';
        }
        $user->email = strtolower( trim( $req->email ));
        if ($req->password && $req->new_password) {
            if (Hash::check($req->password, $user->password)) {
                $user->password = bcrypt($req->new_password);   
            }
            else{
                return redirect()->back()->withInput($req->all())->withErrors(['password' => 'رمز عبور اشتباه است']);
            }
        }
        if($req->hasFile('avatar')) {
            $img = $req->file('avatar');
            $imgName = time().".".$img->getClientOriginalExtension();
            $img->move('files/users/',$imgName);
            $user->avatar = 'files/users/'.$imgName;
        }
        else {
            $user->avatar = 'https://www.gravatar.com/avatar/'.hash( 'sha256', strtolower( trim( $user->email ) )).'?d=mp';
        }
        $user->save();
        return redirect('/profile');
    }
    public function show($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return abort(404);
        }
        $user = User::find($post->user_id);
        $post->user_avatar = $user->avatar;
        $post->user_id = $user->id;
        return view('post', compact('post'));
    }
}
