@extends('layouts.notification')
@section('content')
    <div style="background-color: #610808; color: #fff">
        <br>
        <h1 style="text-align: center;">Восстановление пароля от аккаунта портала SportExperts!</h1>
        <p>Ваш новый пароль: {{ $password }}</p>
        <br>
    </div>
@endsection
