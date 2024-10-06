@extends('layouts.auth')
@php
    $title = 'ثبت نام';
@endphp

@section('content')
    <form  method="post" class="form" action="">
        @csrf
        <div class="floating-input ">
            <input dir="rtl" type="text" name="name" id="name" value="{{ old('name') }}" placeholder=" " >
            <label for="name" >نام</label>
        </div>
        <div class="floating-input ">
            <input dir="rtl" type="text" name="email" id="email" value="{{ old('email') }}" placeholder=" " >
            <label for="email" >ایمیل</label>
        </div>
        <div class="password-container floating-input ">
            <input dir="rtl" class="password" type="password" name="password" id="password" value="{{ old('password') }}" placeholder=" " >
            <label for="password" >رمز عبور</label>
            <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
        </div>
        <button type="submit" class="submit-button">ورود</button>
    </form>
@endsection