@extends('layouts.master')
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
.post {
flex-grow: 1;
width: 100%;
margin: 10px;
display: flex;
flex-direction: row;
}

.post img {
width: 75%;
}

.post-desc {
margin-right: 10px;
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
            <img src="{{asset($post->image)}}" alt="{{$post->title}}">
            <div class="post-desc">
                <p style="font-weight: bold;">{{$post->title}}</p>
                <p>{{$post->body}}</p>
            </div>
        </div>
    @endforeach
</div>
@endsection