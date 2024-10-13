@extends('layouts.master')
@php $title = 'پروفایل ' . $user->name;
@endphp
@section('style')
.btn{
padding: 10px 20px;
background-color: #4CAF50;
color: white;
margin: 10px;
border: none;
cursor: pointer;
font-size: 16px;
border-radius: 5px;
transition: background-color 0.3s;
}
.btn:hover {
background-color: #45a049;
}
.list{
overflow-y: auto;
height: 100px;
}
.list li{
list-style: none;
}
.popup {
display: none;
position: fixed;
left: 0;
top: 0;
width: 100%;
height: 100%;
background-color: rgba(0, 0, 0, 0.5);
justify-content: center;
align-items: center;
}
.dark-mode .popup-content{
background-color: #333 !important;
}
.popup-content {
background-color: white;
padding: 20px;
border-radius: 10px;
width: 300px;
text-align: center;
}

.close {
float: right;
font-size: 24px;
cursor: pointer;
}

.close:hover {
color: red;
}
.profile-box {
width: auto;
height: auto;
min-height: 100%;
margin: auto;
position: absolute;
align-items: center;
display: flex;
flex-direction: column;
top: 0;
right: 0;
left: 0;
padding: 20px;
background-color: white;
}
.dark-mode .profile-box {
background-color: #444 !important;
}
.profile-box img {
width: 100px;
height: 100px;
border-radius: 50%;
}
.profile-box p {
margin: 5px 0;
}
.edit-form{
display: none;
width : 100%;
padding-top : 20px;

}
@media (max-width: 500px) {
.profile-box {
padding-top: 70px;
width: auto !important;
height: auto !important;
border-radius: 0px !important;
}
}
@endsection
@section('content')
<div class="profile-box">
    <img src="{{asset($user->avatar)}}">
    <div><button onclick="openpopup('followers-popup')" class="btn popup-btn" id="followers">دنبال
            کنندگان</button><button onclick="openpopup('following-popup')" class="btn popup-btn" id="following">دنبال
            شوندگان</button></div>
    @if (Auth::user()->id == $user->id)
        <a href="/logout" style="background-color: red !important;" class="btn">خروج</a></a>
        <button onclick="toggleDisplay('edit-form')" class="btn popup-btn" id="edit">ویرایش</button>
        <form id="edit-form" class="edit-form" action="/profile" method="post" enctype="multipart/form-data">
            <br>
            @csrf
            @error('name')
                <p class="error">{{ $message }} <i class="fas fa-exclamation-triangle"></i></p>
            @enderror
            <div class="floating-input ">
                <input dir="rtl" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" placeholder=" ">
                <label for="name">نام</label>
            </div>
            @error('email')
                <p class="error">{{ $message }} <i class="fas fa-exclamation-triangle"></i></p>
            @enderror
            <div class="floating-input ">
                <input dir="rtl" type="text" name="email" id="email" value="{{ old('email', $user->email) }}"
                    placeholder=" ">
                <label for="email">ایمیل</label>
            </div>
            @error('password')
                <p class="error">{{ $message }} <i class="fas fa-exclamation-triangle"></i></p>
            @enderror
            <div class="password-container floating-input ">
                <input dir="rtl" class="password" type="password" name="password" id="password" placeholder=" ">
                <label for="password">رمز عبور قبلی</label>
                <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
            </div>
            @error('new_password')
                <p class="error">{{ $message }} <i class="fas fa-exclamation-triangle"></i></p>
            @enderror
            <div class="floating-input ">
                <input dir="rtl" type="password" name="new_password" id="new_password" value="{{ old('new_password') }}"
                    placeholder=" ">
                <label for="new_password">رمز عبور حدید</label>
            </div>
            @error('avatar')
                <p class="error">{{ $message }} <i class="fas fa-exclamation-triangle"></i></p>
            @enderror
            <div class="floating-input ">
                <input style="background-color: white !important;" dir="rtl" type="file" name="avatar" id="avatar">
                <label for="avatar">عکس پروفایل</label>
            </div>
            <button type="submit" class="submit-button">ویرایش</button>
        </form>
    @else
        <p>{{$user->name}}</p>
        <p>{{$user->email}}</p>
        <a href="/chat/{{$user->id}}">پیام به {{$user->name}}</a>
    @endif
</div>
<div id="following-popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closepopup('following-popup')">&times;</span>
        <h2>دنبال شوندگان</h2>
        <ul class="list">
            <li>
                <a href="/profile/5">علی</a>
            </li>
        </ul>
    </div>
</div>
<div id="followers-popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closepopup('followers-popup')">&times;</span>
        <h2>دنبال کنندگان</h2>
        <ul class="list">
            <li>
                <a href="/profile/5">علی</a>
            </li>
        </ul>
    </div>
</div>
@endsection