@extends('admin.base')

@section('content')
    <main>
        @include('admin.pages.' . $page)
    </main>
@endsection
