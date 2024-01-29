@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Tipologia: {{ $type->name }}</h2>
        <p>Slug: {{ $type->slug }}</p>

        <hr>
        @if (count($type->projects) > 0)
            <h3>Tutti i post di questa categoria</h3>
            <ul>
                @foreach ($type->projects as $project)
                    <li>
                        <a href="{{ route('admin.projects.show', ['project' => $project->slug]) }}">{{ $project->title }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>Nessun progetto ancora presente per questa categoria</p>            
        @endif
       
    </div>
@endsection