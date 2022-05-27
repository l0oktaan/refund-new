<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
    <!-- Styles -->
    
</head>
<body>
    <div id="app">
        <main class="container">
            @yield('content')
        </main>
    </div>
    <style>
        *{
            margin: 0px;
            padding: 0px;
        }
        body{
            font-family: 'Sarabun';
            width: 100%;
        }
        .container{
            width: 100%;
            display: flex;
            justify-content: center;
            align-items:flex-start;
        }
        .mail{
            width: 50%;
            border: 1px solid #aaa;
        }
    </style>
</body>
</html>
