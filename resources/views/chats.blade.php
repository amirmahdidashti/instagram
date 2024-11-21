@extends('layouts.master')
@php $title = 'گفتگو ها';
@endphp
@section('style')
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-color: #f5f5f5;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.container {
    width: 100%;
    max-width: 500px;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    font-size: 24px;
    color: #333;
    margin-bottom: 20px;
}

.chat-list {
    list-style: none;
}

.chat-item {
    display: flex;
    align-items: center;
    padding: 12px;
    margin-bottom: 10px;
    background-color: #fafafa;
    border-radius: 6px;
    transition: background-color 0.3s ease;
}

.chat-item:hover {
    background-color: #f0f0f0;
}

.chat-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    width: 100%;
    color: inherit;
}

.chat-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 12px;
    flex-shrink: 0;
}

.chat-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.chat-info {
    flex: 1;
}

.chat-name {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 4px;
}

.last-message {
    font-size: 14px;
    color: #666;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

@endsection
@section('content')
<div class="container">
    <h1>لیست چت‌ها</h1>
    <ul class="chat-list">
        @foreach ($chats as $chat)
            <li class="chat-item">
                <a href="{{ '/chat/' . $chat->pivot->id }}" class="chat-link">
                    <div class="chat-avatar">
                        <img src="{{ asset($chat->avatar) }}" alt="Avatar">
                    </div>
                    <div class="chat-info">
                        <span class="chat-name">{{ $chat->name }}</span>
                        <p class="last-message">{{ $chat->lastMessage ?(($chat->lastMessage->user_id == Auth::user()->id ? 'شما' : $chat->name ) .' : '.$chat->lastMessage->text) : 'بدون پیام' }}</p>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection