@extends('groups::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('groups.name') !!}</p>
@endsection
