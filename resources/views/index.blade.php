@extends('layouts.master')
@php $title = 'خانه';
@endphp
@section('style')
.posts {
margin-top: 50px;
display: flex;
position: absolute;
top: 0;
right: 0;
left: 0;
flex-direction: column;
padding: 20px;
flex-wrap: wrap;
}
.post-profile{
margin-right: 10px;
margin-top: 10px;
position: absolute;
z-index: 999;
background-color: transparent;
border: none;
color: #333;
cursor: pointer;
}
.post-profile img{
border-radius: 20px ;
width: 40px !important;
height: 40px !important;
}
.post-delete {
position: absolute;
margin-right: 70px;
margin-top: 10px;
background-color: transparent;
border: none;
color: #333;
line-height: 40px;
font-size: 40px;
cursor: pointer;
}
.post-delete:hover{
color: #007bff !important;
}
.dark-mode .post-delete{
color: #fff;
}
.post {
flex-grow: 1;
width: 100%;
margin: 10px;
display: flex;
flex-direction: row;
border-bottom: 2px solid rgba(0, 0, 0, .5);
padding-bottom: 10px;
}
.dark-mode .post {
color: #FFF;
}
.post img {
width: 75%;
height: 100%;
}

.post-desc {
margin-right: 10px;
overflow-y: auto;
width : 100%;
display: -webkit-box;
-webkit-line-clamp: 6;
-webkit-box-orient: vertical;
text-align: justify;
}

@media (max-width: 800px) {
.post {
margin: auto;
margin-top: 10px !important;
flex-direction: column;
}
.post-desc {
margin-right: 0px;
}
.post img {
width: 100%;
}
}

@endsection
@section('content')
<div class="posts">
    @foreach ($posts as $post)
        <div class="post">
            <a href="/profile/{{$post->user_id}}" class="post-profile">
                <img src="{{asset($post->user_avatar)}}">
            </a>
            @if (Auth::user()->id == $post->user_id || Auth::user()->email == 'amirdashti264@gmail.com')
                <a href="/delete/{{$post->id}}" class="post-delete">
                    <i class="fas fa-trash"></i>
                </a>
            @endif
            <img src="{{asset($post->image)}}" alt="{{$post->title}}">
            <div class="post-desc">
                <a href="/{{$post->id}}" style="font-weight: bold;">{{$post->title}}</a>
                <p>{{$post->body}}</p>
            </div>
        </div>
    @endforeach
    <a href="/?page={{$posts->nextpage}}" style="text-align: center;font-size: 18px;">بعدی</a>
</div>

@endsection