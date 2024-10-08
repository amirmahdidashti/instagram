@extends('layouts.auth')
@php
    $title = 'ورود';
@endphp

@section('content')
<form method="post" class="form" action="">
    @csrf
    @error('email')
        <p class="error">{{ $message }} <i class="fas fa-exclamation-triangle"></i></p>
    @enderror
    <div class="floating-input ">
        <input dir="rtl" type="text" name="email" id="email" value="{{ old('email') }}" placeholder=" ">
        <label for="email">ایمیل</label>
    </div>
    @error('password')
        <p class="error">{{ $message }} <i class="fas fa-exclamation-triangle"></i></p>
    @enderror
    <div class="password-container floating-input ">
        <input dir="rtl" class="password" type="password" name="password" id="password" value="{{ old('password') }}"
            placeholder=" ">
        <label for="password">رمز عبور</label>
        <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
    </div>
    <button type="submit" class="submit-button">ورود</button>
</form>
@endsection