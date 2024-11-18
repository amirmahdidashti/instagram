@extends('layouts.master')
@php $title = 'پست جدید';
@endphp
@section('style')
.add{
    color: #007bff !important;
}
.form{
    height: fit-content;
}
.floating-textarea {
position: relative;
width: 100%;
position: relative;
margin-bottom: 20px;
width: 100%;
}

.floating-textarea textarea {
width: 100%;
padding: 10px 0px;
font-size: 16px;
border: 1px solid #ccc;
border-radius: 5px;
outline: none;
resize: none;
}

.floating-textarea label {
position: absolute;
right: 10px;
top: -15px;
font-size: 16px;
background-color: #fff;
color: #333;
padding: 0 5px;
transition: 0.3s;
pointer-events: none;
}
.dark-mode .floating-textarea label {
background-color: #444;
color: #fff;
}
@media (max-height: 600px) {
.form{
    margin-top : 70px;
}
}
@endsection
@section('content')
<form method="post" class="form" action="" enctype="multipart/form-data">
    @csrf
    @error('title')
        <p class="error">{{ $message }} <i class="fas fa-exclamation-triangle"></i></p>
    @enderror
    <div class="floating-input ">
        <input dir="rtl" type="text" name="title" id="title" value="{{ old('title') }}" placeholder=" ">
        <label for="title">عنوان</label>
    </div>
    @error('body')
        <p class="error">{{ $message }} <i class="fas fa-exclamation-triangle"></i></p>
    @enderror
    <div class="floating-textarea">
        <textarea id="body" rows="6" name="body">{{ old('body') }}</textarea>
        <label for="body">متن:</label>
    </div>
    @error('image')
        <p class="error">{{ $message }} <i class="fas fa-exclamation-triangle"></i></p>
    @enderror
    <div class="floating-input ">
        <input style="background-color: white !important;" dir="rtl" type="file" name="image[]" id="image" multiple>
        <label for="image">عکس</label>
    </div>
    <button type="submit" class="submit-button">ارسال</button>
</form>
@endsection