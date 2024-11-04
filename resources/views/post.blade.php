@extends('layouts.master')
@php
    $title = "کامنت های " . $post->title;
@endphp
@section('style')
body {
display: flex;
justify-content: center;
align-items: center;
flex-direction: column;
min-height: 100vh;
margin: 0;
background-color: #f9f9f9;
direction: rtl;
}
.comments-container {
width: 100%;
max-width: 600px;
background-color: #fff;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
padding: 20px;
border-radius: 8px;
}
.comment {
display: flex;
align-items: flex-start;
margin-bottom: 20px;
}
.comment img {
width: 50px;
height: 50px;
border-radius: 50%;
margin-left: 15px;
}
.comment-content {
flex: 1;
}
.comment-author {
font-weight: bold;
font-size: 1rem;
}
.comment-time {
font-size: 0.8rem;
color: #888;
}
.comment-text {
margin-top: 5px;
font-size: 0.9rem;
color: #333;
line-height: 1.4;
}
@endsection
@section('content')

<div class="comments-container">
    <h3>{{ $title }}</h3>
    <button id="add-comment"
        style="background-color: #4CAF50; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; border-radius: 5px; margin: 10px 0;">افزودن
        کامنت</button>
    <div id="comments" style="overflow-y: auto;max-height: 200px;">
        @foreach ($post->comments as $comment)
            <div class="comment">
                <img src="{{asset($comment->user->avatar)}}" alt="پروفایل کاربر">
                <div class="comment-content">
                    <div class="comment-author">{{ $comment->user->name }}</div>
                    <div class="comment-time">{{ $comment->date }}</div>
                    <div class="comment-text">{{ $comment->body }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
<script>
    const comments = document.getElementById('comments');
    document.getElementById('add-comment').addEventListener('click',  function () {
        Swal.fire({
            title: 'نوشتن کامنت',
            input: 'textarea',
            inputPlaceholder: 'کامنت خود را اینجا بنویسید...',
            showCancelButton: true,
            confirmButtonText: 'ارسال',
            cancelButtonText: 'انصراف',
            preConfirm: (comment) => {
                if (!comment) {
                    Swal.showValidationMessage('لطفاً یک کامنت وارد کنید');
                }
                return comment;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                sendComment(result.value);
            }
        });
    });
    function sendComment(comment) {
        $.ajax({
            url: '/{{ $post->id }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                body: comment
            },
            success: function (response) {
                const newComment = document.createElement('div');
                newComment.className = 'comment';
                newComment.innerHTML = `
                    <img src="{{ asset(Auth::user()->avatar) }}">
                    <div class="comment-content">
                        <div class="comment-author">{{ Auth::user()->name }}</div>
                        <div class="comment-time">{{ \Carbon\Carbon::now()->diffForHumans() }}</div>
                        <div class="comment-text">${comment}</div>
                    </div>
                `;
                comments.appendChild(newComment);
            
            }
        })
    }
</script>
@endsection