@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="mt-4">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Torna Indietro
            </a>
        </div>
        <h1 class="text-center">Modifica il Progetto</h1>

        <div class="row justify-content-center mt-5">
            <div class="col-6 mb-5">
                <form action="{{ route('admin.projects.update', ['project' => $project->slug]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3 has-validation">
                        <label for="title" class="form-label">Titolo</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"" id="title" name="title" value="{{ old('title', $project->title) }}">
                    </div>
                    @error('title')
                    <div class="alert alert-danger">
                        <div>{{ $message }}</div>
                    </div>
                    @enderror

                    <div class="mb-3">
                        <label for="content" class="form-label">Descrizione</label>
                        <textarea class="form-control" id="content" rows="3" name="content">{{ old('content', $project->content) }}</textarea>
                    </div>

                    <div class="mb-2">
                        <label for="type">Seleziona tipologia</label>
                        <select class="form-select" name="type_id" id="type">
                            <option @selected(!old('type_id', $project->type_id)) value="">Nessuna tipologia</option>
                            @foreach ($types as $type)
                                <option @selected(old('type_id', $project->type_id) == $type->id) value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <h6>Seleziona le tecnologie</h6>
                        @foreach ($technologies as $technology)
                            <div class="form-check">
                                <input @checked( $errors->any() ? in_array($technology->id, old('technologies', [])) : $project->technologies->contains($technology)) type="checkbox" id="technology-{{ $technology->id }}" value="{{ $technology->id }}" name="technologies[]">
                                <label for="technology-{{ $technology->id }}">
                                    {{ $technology->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Immagine</label>
                        <input class="form-control" type="file" id="cover_image" name="cover_image">
                    </div>

                    <div class="mb-2">
                        <img class="w-50" id="preview-img" src="{{ asset('storage/' . $project->cover_image) }}" alt="">
                    </div>

                    <button class="btn btn-success" type="submit">Salva</button>
                   
                </form>
            </div>
        </div>
       
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/image-preview.js'])
@endsection