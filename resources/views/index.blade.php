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
    <div class="post">
        <img src="https://flowbite.com/docs/images/examples/image-1@2x.jpg" alt="">
        <div class="post-desc">
            <p style="font-weight: bold;">پست جدید</p>
            <p>سلام لورم اسپیون لورم اسپیون لورم اسپیون لورم اسپیون لورم اسپیون</p>
        </div>
    </div>
</div>
@endsection