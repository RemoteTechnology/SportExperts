@extends('layouts.notification')
@section('content')
    <div style="background-color: #610808; color: #fff">
        <br>
        <h1 style="text-align: center;">Вас пригласили на событие!</h1>
        <a href="http://localhost:8080/registration/?invite_user_id={{ $attributes['invited_user_id'] }}&&event_id={{ $attributes['event_id'] }}">Записаться</a>
        <br>
    </div>
@endsection
