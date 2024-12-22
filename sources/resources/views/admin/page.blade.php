@extends('admin.base')

@section('content')
    <main style="width: 82%;">
        @include('admin.pages.' . $page)
    </main>
@endsection
