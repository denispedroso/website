@extends('layouts.app')

@section('content')
<div class="container mt-5 text-center">
    <h1>{{ $flex->title }}<span class="badge badge-secondary mt-4">New</span></h1>
    <p class="lead text-center">
        {{ $flex->body }}
    </p>
    <div class="alert alert-success" role="alert">
        A simple success alert with <a href="{{ $flex->link }}" class="alert-link">an example link</a>. Give it a click if you like.
    </div>
</div>
@endsection