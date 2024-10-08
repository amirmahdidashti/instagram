<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>{{ $title ?? 'Page Title' }}</title>
</head>

<body class="theme">
    <button class="dark-mode-button" onclick="toggleDarkMode(); setTheme(document.body.className);">
        <i class="fas fa-moon"></i>
        <i class="fas fa-sun "></i>
    </button>

    <script>
        const darkModeButton = document.querySelector('.dark-mode-button');

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            darkModeButton.classList.toggle('dark-mode');
        }
    </script>
    @yield('content')
    <script src="{{ asset('js/passwordhide.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>