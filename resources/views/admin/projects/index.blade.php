@extends('layouts.admin')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Lista</h1>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Torna Indietro
            </a>
        </div>
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div class="text-end">
            <a class="btn btn-primary" href="{{ route('admin.projects.create') }}">Aggiungi un Progetto</a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <th scope="row">{{ $project->id }}</th>
                        <td>{{ $project->title }}</td>
                        <td>
                            <a class="btn btn-success"
                                href="{{ route('admin.projects.show', ['project' => $project->slug]) }}">Dettagli</a>
                            <a class="btn btn-warning"
                                href="{{ route('admin.projects.edit', ['project' => $project->slug]) }}">Modifica</a>
                            <form action="{{ route('admin.projects.destroy', ['project' => $project->slug]) }}"
                                class="d-inline-block" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-delete" type="submit" data-title="{{ $project->title }}">
                                    <div>Elimina</div>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="modal" tabindex="-1" id="delete-modal">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Cancella progetto</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p>Vuoi veramente cancellare il progetto: <span id="title-to-delete"></span></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                  <button type="button" id="action-delete" class="btn btn-danger">Sì, voglio cancellarlo</button>
                </div>
              </div>
            </div>
        </div>
        <div>
            {{ $projects->links() }}
        </div>
    </div>
@endsection
