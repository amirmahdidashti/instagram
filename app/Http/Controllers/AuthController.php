<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Auth;
use Validator;
class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function loginPost(Request $req)
    {
        $mesages = [
            'email.required' => 'ایمیل نباید خالی باشد',
            'email.email' => 'فرمت ایمیل اشتباه است',
            'password.required' => 'رمز عبور نباید خالی باشد',
        ];
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($req->all(), $rules, $mesages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }
        $user = User::where('email', $req->email)->first();
        if ($user) {
            if (Hash::check($req->password, $user->password)) {
                Auth::login($user);
                return redirect('/');
            } else {
                return redirect()->back()->withInput($req->all())->withErrors(['password' => 'رمز عبور اشتباه است']);
            }
        }
        return redirect("/register")->withInput($req->all());
    }
    public function register()
    {
        return view('auth.register');
    }
    public function registerPost(Request $req)
    {
        $mesages = [
            'name.required' => 'نام نباید خالی باشد',
            'email.required' => 'ایمیل نباید خالی باشد',
            'email.email' => 'فرمت ایمیل اشتباه است',
            'email.unique' => 'ایمیل تکراری است',
            'password.min' => 'رمز عبور باید حداقل 8 کاراکتر باشد',
            'password.required' => 'رمز عبور نباید خالی باشد',
            'avatar.mimes' => 'فرمت عکس باید jpeg, jpg, png, gif باشد',
            'avatar.max' => 'حجم عکس باید حداکثر 2 مگابایت باشد',
        ];
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'avatar' => 'mimes:jpeg,jpg,png,gif|max:2048',
        ];
        $validator = Validator::make($req->all(), $rules, $mesages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }
        $user = new User();
        $user->name = $req->name;
        $user->email = strtolower( trim( $req->email ));
        $user->password = bcrypt(trim($req->password ));
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
        Auth::login($user);
        return redirect('/');
    }
}
