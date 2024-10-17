<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>{{$post->title}}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100..900&display=swap');

        * {
            font-family: vazirmatn;
        }

        .dark-mode {
            background-color: #333 !important;

        }

        body {
            background-color: white;
            transition: background-color 0.3s ease;

        }

        .fa-moon {
            display: block !important;
        }

        .dark-mode .fa-moon {
            display: none !important;
        }

        .dark-mode .fa-sun {
            display: block !important;
        }

        .fa-sun {
            display: none !important;
        }

        .dark-mode-button {
            position: fixed;
            top: 20px;
            right: 70px;
            z-index: 999;
            background-color: transparent;
            border: none;
            color: #333;
            font-size: 40px;
            cursor: pointer;
        }


        .dark-mode-button:hover {
            color: #007bff !important;
        }

        .dark-mode .dark-mode-button {
            color: #fff;
        }

        .container {
            width: 500px;
            height: auto;
            max-height: 400px;
            margin: auto;
            position: absolute;
            align-items: center;
            justify-content: center;
            display: flex;
            flex-direction: column;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            border-radius: 10px;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .container img {
            max-width: 500px;
            max-height: 230px;
            border-radius: 10px;
        }

        .dark-mode .container {
            background-color: #444;
            color: #fff;
        }

        .post-profile {
            right: 20px;
            top: 10px;
            position: absolute;
            z-index: 999;
            background-color: transparent;
            border: none;
            color: #333;
            cursor: pointer;
        }

        .post-profile img {
            border-radius: 20px;
            width: 40px !important;
            height: 40px !important;
        }

        .post-delete {
            position: absolute;
            right: 70px;
            top: 10px;
            background-color: transparent;
            border: none;
            color: #333;
            line-height: 40px;
            font-size: 40px;
            cursor: pointer;
        }

        .post-delete:hover {
            color: #007bff !important;
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

        .home:hover{
            color: #007bff !important;
        }
        .dark-mode .home{
            color: #fff;
        }
        .dark-mode .post-delete {
            color: #fff;
        }

        @media (max-width: 500px) {
            .dark-mode .dark-mode-button:hover {
                color: #fff !important;
            }

            .container {
                padding-top: 60px;
                width: auto;
                height: auto;
                max-height: 100vh;
            }

            .post-delete {
                top: 20px;
                right: 120px;
            }

            .post-profile {
                top: 20px;
                right: 120px;
            }

            .dark-mode-button:hover {
                color: #333 !important;
            }
        }
    </style>
</head>

<body class="theme">
    <button class="dark-mode-button" onclick="toggleDarkMode(); setTheme(document.body.className);">
        <i class="fas fa-moon"></i>
        <i class="fas fa-sun "></i>
    </button>
    <a href="/" class="home">
            <i class="fas fa-home"></i>
        </a>
    <div class="container">
        <a href="/profile/{{$post->user_id}}" class="post-profile">
            <img src="{{asset($post->user_avatar)}}">
        </a>
        @auth
            @if (Auth::user()->id == $post->user_id || Auth::user()->email == 'amirdashti264@gmail.com')
                <a href="/delete/{{$post->id}}" class="post-delete">
                    <i class="fas fa-trash"></i>
                </a>
            @endif
        @endauth
        <img src="{{$post->image}}" alt="{{$post->title}}">
        <div dir="rtl"
            style="overflow-x: auto;overflow-wrap: break-word; word-break: break-word;text-align: justify;margin-top: 10px;">
            <h1>{{$post->title}}</h1>
            <p>{{$post->body}}</p>
        </div>
    </div>
    <script>
        const darkModeButton = document.querySelector('.dark-mode-button');

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            darkModeButton.classList.toggle('dark-mode');
        }
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>