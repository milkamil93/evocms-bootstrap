@extends('layout')

@section('pagebody')
    <div class="container">
        <div class="user-content">
            {!! $documentObject['content'] !!}
        </div>
    </div>
@endsection
