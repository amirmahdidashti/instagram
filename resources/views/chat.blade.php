@extends('layouts.master')
@php $title = 'گفتگو با ' . $user->name;
@endphp
@section('style')
/* بدنه صفحه */
body, html {
height: 100%;
display: flex;
align-items: center;
justify-content: center;
margin: 0;
}

/* کانتینر چت */
.chat-container {
width: 400px;
height: 500px;
display: flex;
flex-direction: column;
background-color: #fff;
border-radius: 10px;
box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
overflow: hidden;
}
.dark-mode .chat-container {
background-color: #444;
}
/* بخش نمایش پیام ها */
.chat-messages {
flex: 1;
padding: 10px;
overflow-y: auto;
display: flex;
flex-direction: column;
gap: 8px;
}

/* استایل پیام ها */
.message {
max-width: 80%;
padding: 8px 12px;
border-radius: 12px;
color: white;
}

.message.user {
background-color: #007bff;
align-self: flex-end;
}

.message.other {
background-color: #e74c3c;
align-self: flex-start;
}

/* اینپوت و دکمه ارسال */
.chat-input {
display: flex;
border-top: 1px solid #ddd;
}

.chat-input input {
flex: 1;
padding: 10px;
border: none;
outline: none;
font-size: 16px;
}

.chat-input button {
padding: 10px 20px;
background-color: #007bff;
color: white;
border: none;
cursor: pointer;
transition: background-color 0.3s;
}

.chat-input button:hover {
background-color: #0056b3;
}
@media (max-width: 600px) {
.chat-container {
width: 100%;
height: 100%;
border-radius: 0;
padding-top: 60px;
}
body, html {
display: block;
}
}
@endsection
@section('content')
<div class="chat-container">
    <div id="chat-messages" class="chat-messages">
        @foreach ($messages as $message)
            <div class="message {{ $message->sender_id == Auth::user()->id ? 'user' : 'other' }}">
                {{ $message->text }}
            </div>
        @endforeach

    </div>
    <div class="chat-input">
        @csrf
        <input type="text" id="message-input" autofocus placeholder="پیام خود را بنویسید...">
        <button onclick="sendMessage()">ارسال</button>
    </div>
</div>
<script>
    const chatMessages = document.getElementById('chat-messages');
    const messageInput = document.getElementById('message-input');
    chatMessages.scrollTop = chatMessages.scrollHeight;
    document.addEventListener('keydown', function (event) {
        if (event.keyCode === 13) {
            sendMessage();
        }
    });
    function sendMessage() {
        $.ajax({
            url: '/chat/{{ $id }}',
            data: {
                _token: '{{ csrf_token() }}',
                message: messageInput.value
            },
            type: 'post'
        })
    }

    Pusher.logToConsole = true;
    var pusher = new Pusher('afe67a7ef0421517e32b', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('{{$id}}');
    channel.bind('new-message', function (data) {
        if (data.sender_id == {{Auth::user()->id}}) {
            chatMessages.innerHTML += '<div class="message user">' + data.text + '</div>';
        }
        else{
            chatMessages.innerHTML += '<div class="message other">' + data.text + '</div>';
        }
        chatMessages.scrollTop = chatMessages.scrollHeight;
        messageInput.value = '';
    });
</script>
@endsection