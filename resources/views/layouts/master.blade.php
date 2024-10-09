<!DOCTYPE html>
<html dir="rtl" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>{{ $title ?? 'Page Title' }}</title>
    <style>
        .profile {
            position: absolute;
            top: 20px;
            right: 70px;
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
            right: 120px;
            background-color: transparent;
            border: none;
            color: #333;
            line-height: 40px;
            font-size: 40px;
            cursor: pointer;
        }

        .dark-mode-button {
            position: absolute;
        }

        .profile img {
            border-radius: 20px;
            width: 40px;
            height: 40px;
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
        <a href="/logout" class="profile">
            <img src="{{asset(auth()->user()->avatar)}}">
        </a>
        <a href="/newpost" class="add">
            <i class="fas fa-plus"></i>
        </a>
    </div>
    @yield('content')
    <script>
        const darkModeButton = document.querySelector('.dark-mode-button');

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            darkModeButton.classList.toggle('dark-mode');
        }
    </script>
    <script src="{{ asset('js/passwordhide.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>