@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="my-4">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Torna Indietro
            </a>
        </div>
        <h1>{{ $project->title }}</h1>
        <div>
            Tipologia: {{ $project->type ? $project->type->name : 'Nessuna tipologia' }}
        </div>
        @if ($project->cover_image)
            <div class="">
                <img class="w-50" src="{{ asset('storage/' . $project->cover_image) }}" alt="">
            </div>
        @else
            <p>Nessuna immagine presente</p>
        @endif
        <hr>
        <p>{{ $project->content }}</p>
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    </div>
@endsection