@extends('layouts.app')

@section('content')
<div class="container mt-2 text-center">
    <div class="container mx-1">
        <h3>Endereço:</h3>
        <h3>R. João Rodrigues Pinheiro, 919 - Capão Raso, Curitiba - PR</h3>
    </div>
    <div class="container mt-3">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3600.784856326481!2d-49.30554618498415!3d-25.512220783750685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94dcfd50a4f457db%3A0x8b8e07c1437b7810!2sDTP%20Motoshop!5e0!3m2!1spt-BR!2sbr!4v1582569318686!5m2!1spt-BR!2sbr" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
@endsection