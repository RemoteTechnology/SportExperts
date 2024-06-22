@extends('layouts.notification')
@section('content')
    <div style="background-color: #610808; color: #fff">
        <br>
        <h1 style="text-align: center;">Вас пригласили на событие!</h1>
        <a href="/{{ $personalUrl }}">Записаться</a>
        <span>{{ $personalUrl }}</span>
        <br>
    </div>
@endsection
