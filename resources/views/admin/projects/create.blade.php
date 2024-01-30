@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="mt-4">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Torna Indietro
            </a>
        </div>
        <h1 class="text-center">Crea un Progetto</h1>

        <div class="row justify-content-center mt-5">
            <div class="col-6 mb-5">
                <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3 has-validation">
                        <label for="title" class="form-label">Titolo</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}">
                    </div>
                    @error('title')
                        <div class="alert alert-danger">
                            <div>{{ $message }}</div>
                        </div>
                    @enderror

                    <div class="mb-3">
                        <label for="content" class="form-label">Descrizione</label>
                        <textarea class="form-control" id="content" rows="3" name="content">{{ old('content') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="type">Seleziona tipologia</label>
                        <select class="form-select" name="type_id" id="type">
                            <option @selected(!old('type_id')) value="">Nessuna tipologia</option>
                            @foreach ($types as $type)
                                <option @selected(old('type_id') == $type->id) value="{{ $type->id }}">{{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-5">
                        <h6>Seleziona le tecnologie</h6>
                        @foreach ($technologies as $technology)
                            <div class="form-check">
                                <input @checked(in_array($technology->id, old('technologies', []))) type="checkbox" id="technology-{{ $technology->id }}" value="{{ $technology->id }}" name="technologies[]">
                                <label for="technology-{{ $technology->id }}">
                                    {{ $technology->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label for="cover_image" class="form-label">Immagine</label>
                        <input class="form-control" type="file" id="cover_image" name="cover_image"
                            value="{{ old('cover_image') }}">
                    </div>

                    <button class="btn btn-success" type="submit">Salva</button>

                </form>
            </div>
        </div>

    </div>
@endsection
