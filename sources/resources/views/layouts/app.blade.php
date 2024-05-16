<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">


    <!-- Css & Scripts -->
    @vite([
    'resources/css/app.css',
    'resources/css/loader.css',
    'resources/js/app.js'
    ])
</head>
<body id="app">
    <header-component></header-component>
    <main class="wrapper">
        @yield('content')
    </main>
    <section id="loader">
        <div class="lds-ripple"><div></div><div></div></div>
    </section>
    <script type="text/javascript">
        window.onload = function() {
            document.getElementById('loader').style.display = 'none';
        };
    </script>
</body>
</html>
