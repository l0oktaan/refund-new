<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'e-Withdraw') }}</title>



    <link rel="stylesheet" type="text/css" href="/css/app.css">

</head>
<body>
    <div id="app">
        <router-view></router-view>
    </div>
    <script type="text/javascript" src="/js/app.js"></script>



</body>
</html>
