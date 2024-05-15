@extends('layouts.notification')
@section('content')
    <div style="background-color: #610808; color: #fff">
        <br>
        <h1 style="text-align: center;">Здравствуйте!</h1>
        <h3 style="padding: 25px;">
            Благодарим Вас за регистрацию на сайте <a href="{{ $link }}">http:sport-experts.ru</a> <br>
            Для Вас создан личный кабинет. Для входа в него используйте, пожалуйста:
        </h3>
        <div style="width: 500px; margin: 0 auto;">
            <div style="padding: 15px; border-radius: 15px; background-color: aliceblue;">
                <p>Логин: {{ $login }}</p>
                <p>Пароль: {{ $password }}</p>
            </div>
        </div>
        <br>
    </div>
@endsection
