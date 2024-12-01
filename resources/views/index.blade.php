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
z-index: 999;
}
.post-delete:hover{
color: #007bff !important;
}
.dark-mode .post-delete{
color: #fff;
}
.post {
flex-grow: 1;
width:100%;
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
width: 100%;
height: 100%;
object-fit: cover;
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
.post-aks{
    width:500px
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
.post .splide {
width: 100%;
}
}
.pagination {
    display: flex;
    list-style: none;
    justify-content: center;
    padding: 0;
}

.pagination li {
    margin: 0 5px;
}

.pagination li a, .pagination li span {
    display: block;
    padding: 10px 15px;
    border: 1px solid #ddd;
    text-decoration: none;
    color: #333;
}

.pagination li.active span {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.pagination li.disabled span {
    color: #ccc;
}

.pagination li a:hover {
    background-color: #f0f0f0;
}
.time {
font-size: 0.8rem;
color: #888;
}
@endsection
@section('content')
<div class="posts">
    @foreach ($posts as $post)
        <div id="post-{{$post->id}}" class="post">
            <a href="/profile/{{$post->user->id}}" class="post-profile">
                <img src="{{asset($post->user->avatar)}}">
            </a>
            @if (Auth::user()->id == $post->user->id || Auth::user()->email == 'amirdashti264@gmail.com')
                <a href="javascript:void(0)" class="post-delete" onclick="deletePost({{$post->id}})">
                    <i class="fas fa-trash"></i>
                </a>
            @endif
            <section dir="ltr" class="post-aks splide" aria-label="Splide Basic HTML Example">
                <div class="splide__track">
                	<ul class="splide__list">
                        @foreach ($post->images as $img)
                            <li class="splide__slide"><img src="{{asset($img->image)}}" alt="{{$post->title}}"></li>
                        @endforeach
                	</ul>
                 </div>
            </section>
            <!-- <img src="{{asset($post->image)}}" alt="{{$post->title}}"> -->
            <div class="post-desc">
                <a href="/{{$post->id}}" style="font-weight: bold;">{{$post->title}}</a>
                <div class="time">{{ \Morilog\Jalali\Jalalian::fromCarbon($post->created_at)->ago() }}</div>
                <p>
                خلاصه شده:
                <br>
                {{Illuminate\Support\Facades\Http::asForm()->post('https://amirdashtitest.ir/ai', ['question' => 'در حد 4 جمله خلاصه کن بدون حرف اضافه اگه به خطا برخوردی هیچی نگو اگه نامهفهوم بود بنویس نامفهوم است:'.$post->body])}}
                <br>
                کامل:
                <br>
                {{$post->body}}</p>
            </div>
        </div>
    @endforeach
    {{$posts->links()}}
    @if (request()->path() == '/')
        <a style="text-align: center;" href="/all">همه پست ها</a>
    @endif
</div>
<script>
    var elms = document.getElementsByClassName( 'splide' );
    for ( var i = 0; i < elms.length; i++ ) {
      new Splide( elms[ i ] ).mount();
    }
    function deletePost(id) {
        $.ajax({
            url: '/delete/' + id,
            type: 'get',
            success: function() {
                document.getElementById('post-' + id).remove();
                Swal.fire({
                    icon: 'success',
                    title: 'پست با موفقیت حذف شد',
                })
            }
        });
    }
</script>
@endsection