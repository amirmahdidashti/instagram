@extends('layouts.auth')
@php
    $title = 'ورود';
@endphp

@section('content')
    <form  method="post" class="form" action="">
        @csrf
        <div class="input-group floating-input ">
            <input dir="rtl" type="text" name="email" id="email" value="{{ old('email') }}" placeholder="" >
            <label for="email" >ایمیل</label>
        </div>
        <div class="password-container input-group floating-input ">
            <input dir="rtl" class="password" type="password" name="password" id="password" value="{{ old('password') }}" placeholder="" >
            <label for="password" >رمز عبور</label>
        </div>
        <a href="#" onclick="hideAndShowPassword()" class="show-password">نمایش رمز عبور</a>
        <button type="submit" class="submit-button">ورود</button>
    </form>
    <script>
        function hideAndShowPassword() {
            if ($('.password').attr('type') == 'password') {
                $('.password').attr('type', 'text');
                $('.show-password').text('مخفی کردن رمز عبور');
            } else {
                $('.password').attr('type', 'password');
                $('.show-password').text('نمایش رمز عبور');
            }
        }
    </script>
@endsection