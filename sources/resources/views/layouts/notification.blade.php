<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
    </head>
    <body>
        <!-- HEADER -->
        <div style="background-color: #610808;">
            <img src="{{ asset('images/logo.png') }}" alt="SportExperts">
        </div>
        @yield('content')
        <!-- FOOTER -->
        <div style="background-color: #222; color: #fff">
            <div style="text-align: center;">
                <p>
                    <b>Хорошего дня!</b>
                </p>
                <p>С уважением, команда SportExperts.</p>
            </div>
        </div>
    </body>
</html>
