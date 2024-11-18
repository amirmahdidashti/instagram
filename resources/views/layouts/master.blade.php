<!DOCTYPE html>
<html dir="rtl" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>{{ $title ?? 'Page Title' }}</title>
    <script src="
https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
"></script>
    <link href="
https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css
" rel="stylesheet">
    <style>
        .profile {
            position: absolute;
            top: 20px;
            right: 120px;
            z-index: 999;
            background-color: transparent;
            border: none;
            color: #333;
            font-size: 24px;
            cursor: pointer;
        }

        .add {
            position: absolute;
            top: 20px;
            right: 170px;
            background-color: transparent;
            border: none;
            color: #333;
            z-index: 999;
            line-height: 40px;
            font-size: 40px;
            cursor: pointer;
        }

        .add:hover {
            color: #007bff !important;
        }

        .dark-mode .add {
            color: #fff;
        }

        .home {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: transparent;
            border: none;
            color: #333;
            line-height: 40px;
            z-index: 999;
            font-size: 40px;
            cursor: pointer;
        }

        .home:hover {
            color: #007bff !important;
        }

        .dark-mode .home {
            color: #fff;
        }

        .chat {
            position: absolute;
            top: 20px;
            z-index: 999;
            right: 220px;
            background-color: transparent;
            border: none;
            color: #333;
            line-height: 40px;
            font-size: 40px;
            cursor: pointer;
        }

        .chat:hover {
            color: #007bff !important;
        }

        .dark-mode .chat {
            color: #fff;
        }

        .dark-mode-button {
            position: absolute;
        }

        .profile img {
            border-radius: 20px;
            width: 40px;
            height: 40px;
        }

        .chat .badge {
            position: absolute;
            top: -10px;
            right: -10px;
            padding: 5px 10px;
            line-height: 1;
            border-radius: 50%;
            background-color: red;
            color: white;
            font-size: 12px;
        }

        .search {
            position: absolute;
            top: 20px;
            z-index: 999;
            right: 270px;
            background-color: transparent;
            border: none;
            color: #333;
            line-height: 40px;
            font-size: 40px;
            cursor: pointer;
        }

        .search:hover {
            color: #007bff !important;
        }

        .dark-mode .search {
            color: #fff;
        }

        @yield('style')
    </style>
</head>

<body class="">
    <div>
        <button class="dark-mode-button" onclick="toggleDarkMode(); setTheme(document.body.className);">
            <i class="fas fa-moon"></i>
            <i class="fas fa-sun "></i>
        </button>
        <a href="/profile" class="profile">
            <img src="{{asset($avatar)}}">
        </a>
        <a href="/newpost" class="add">
            <i class="fas fa-plus"></i>
        </a>
        <a href="/" class="home">
            <i class="fas fa-home"></i>
        </a>
        <a href="/chat" class="chat">
            <i class="fas fa-envelope"></i>
            <span class="badge">{{$unreadCount}}</span>
        </a>
        <a href="/search" class="search">
            <i class="fas fa-search"></i>
        </a>
    </div>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const darkModeButton = document.querySelector('.dark-mode-button');

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            darkModeButton.classList.toggle('dark-mode');
        }
        @if (session('message'))
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'پیام جدید!',
                    text: '{{ session('message') }}',
                    icon: 'info',
                    confirmButtonText: 'باشه',
                    timer: 2000,
                    timerProgressBar: true,
                });
            })
        @endif
    </script>
    <script src="{{ asset('js/passwordhide.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>