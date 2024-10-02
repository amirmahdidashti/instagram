<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" ></script>
    
    <title>{{ $title ?? 'Page Title' }}</title>
</head>
<body>
    @yield('content')
</body>
</html>