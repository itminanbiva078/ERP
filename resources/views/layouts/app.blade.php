<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('frontant/css/style.css') }}" rel="stylesheet">
    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/admin.js') }}" defer></script>

</head>
<body>
    <div id="app">
        <main class="">
            @yield('content')
        </main>
    </div>
    <!-- <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js')}}" ></script> -->
    <script src="https://unpkg.com/typeit@8.2.0/dist/index.umd.js"></script>
</body>
</html>
