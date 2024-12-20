<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Follower;
use App\Models\comment;
use Carbon\Carbon;
use App\Models\Image;
use Auth;
use Validator;
use Hash;
class SiteController extends Controller
{
    public function index()
    {
        $myFollowing = Follower::where('follower_id', Auth::user()->id)->pluck('following_id');
        $posts = Post::whereIn('user_id', $myFollowing)->orderBy('created_at', 'desc')->paginate(10);
        foreach ($posts as $post) {
            $post->images = Image::where('type', 1)->where('subject_id', $post->id)->get();
            $post->user->avatar = Image::where('type', 0 )->where('subject_id', $post->user_id)->first()->image;
        }
        return view('index', compact('posts'))->with('title', 'خانه');
    }
	public function search(Request $req)
    {
        if (isset($req->s)) {
            $s = $req->s;
            $users = User::where('name','like','%'.$req->s.'%')->limit(5)->get();
            foreach ($users as   $user) {
                $user->avatar = Image::where('type', 0 )->where('subject_id', $user->id)->first()->image;
            }
            return $users;
        }
        return view('search');
    }
    public function all()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);;
        foreach ($posts as $post) {
            $post->images = Image::where('type', 1)->where('subject_id', $post->id)->get();
            $post->user->avatar = Image::where('type', 0 )->where('subject_id', $post->user_id)->first()->image;
        }
        return view('index', compact('posts'))->with('title', 'همه پست ها');;   
    }
    public function userPosts($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts->orderBy('created_at', 'desc')->paginate(10);;
        foreach ($posts as $post) {
            $post->images = Image::where('type', 1)->where('subject_id', $post->id)->get();
            $post->user->avatar = Image::where('type', 0 )->where('subject_id', $post->user_id)->first()->image;
        }
        return view('index', compact('posts'))->with('title', 'پست های ' . $user->name );;
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
            'image.*' => 'required|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ];
        $validator = Validator::make($req->all(), $roles, $message);
        if ($validator->fails() ) {
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }
        if (! $req->hasFile('image')) {
            return redirect()->back()->withErrors(['image' => 'عکس نباید خالی باشد'])->withInput($req->all());
        }
        $user = Auth::user();
        $post = new Post();
        $post->user()->associate($user);
        $post->title = $req->title;
        $post->body = $req->body;
        $post->images;
        $post->save();
        foreach ($req->file('image') as $img) {
            $imgName =  uniqid().".".$img->getClientOriginalExtension();
            $img->move('files/posts/', $imgName);
            Image::create(['image' =>  'files/posts/' . $imgName, 'type' => 1 , 'subject_id' => $post->id]);
        }
        return redirect('/')->with('message', 'پست شما با موفقیت ایجاد شد');
    }
    public function delete($id)
    {
        if (Auth::user()->id == Post::findOrFail($id)->user_id || Auth::user()->email == 'amirdashti264@gmail.com') {
            $post = Post::find($id);
            $post->delete();
            return redirect('/')->with('message', 'پست شما با موفقیت حذف شد');
        }
        return abort(403);
    }
    public function profile($id = null)
    {
    
        if ($id ) {
            $user = User::findOrFail($id);
        }
        elseif($id=='0'){
            return abort(404);
        }
        else {
            $user = Auth::user();
        }
        $user->avatar = Image::where('type', 0 )->where('subject_id', $user->id)->first()->image;
        return view('profile', compact('user'));
    }

    public function profilePost(Request $req)
    {
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
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
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
        if (strtolower(trim($req->email)) != $user->email) {
            $user->avatar = 'https://www.gravatar.com/avatar/' . hash('sha256', strtolower(trim($req->email))) . '?d=mp';
        }
        $user->email = strtolower(trim($req->email));
        if ($req->password && $req->new_password) {
            if (Hash::check($req->password, $user->password)) {
                $user->password = bcrypt($req->new_password);
            } else {
                return redirect()->back()->withInput($req->all())->withErrors(['password' => 'رمز عبور اشتباه است']);
            }
        }
        $user->save();
        $avatar = Image::where('type', 0 )->where('subject_id', Auth::user()->id)->first();
        if ($req->hasFile('avatar')) {
            $img = $req->file('avatar');
            $imgName = uniqid() . "." . $img->getClientOriginalExtension();
            $img->move('files/users/', $imgName);
            $avatar->image = 'files/users/' . $imgName;
        } else {
            $avatar->image = 'https://www.gravatar.com/avatar/' . hash('sha256', strtolower(trim($user->email))) . '?d=mp';
        }
        $avatar->save();
        return redirect('/profile')->with('message', 'پروفایل شما با موفقیت ویرایش شد');
    }
    public function show($id)
    {
        $post = Post::findOrFail($id);
        foreach ($post->userComments as $user) {
            $user->avatar = Image::where('type', 0 )->where('subject_id', $user->id)->first()->image;
        }
        return view('post', compact('post'));
    }
    public function comment(Request $req,$id)
    {
        $message = [
            'body.required' => 'متن نباید خالی باشد',
        ];
        $roles = [
            'body' => 'required',
        ];
        $validator = Validator::make($req->all(), $roles, $message);
        if ($validator->fails()) {
            return abort(500);
        }
        $post = Post::findOrFail($id);
        $post->userComments()->attach(Auth::user(), ['body' => $req->body]);
        return 1;
    }
    public function follow($id)
    {
        if (Auth::user()->id == $id) {
            return abort(403);
        }
        elseif (Auth::user()->followings->contains($id)) {
            Auth::user()->followings()->detach($id);
            return "دنبال کردن";
        }
        else{
            $user = Auth::user();
            $user->followings()->attach($id);
            $user->save();
            return "لغو دنبال کردن";
        }
    }
}

