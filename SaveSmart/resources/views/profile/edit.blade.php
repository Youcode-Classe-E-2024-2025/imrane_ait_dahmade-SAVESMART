@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Gérer les Profils') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Formulaire de création de profil -->
                    <form action="{{ route('profiles.store') }}" method="POST" class="mb-4">
                        @csrf
                        <h5>{{ __('Créer un nouveau profil') }}</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Nom du profil" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="color" name="color" class="form-control form-control-color"
                                       value="#563d7c" title="Choisir une couleur">
                            </div>
                            <div class="col-md-2 mb-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    {{ __('Créer') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <!-- Liste des profils -->
                    <h5 class="mt-4">{{ __('Profils existants') }}</h5>
                    
                    @if($profiles && $profiles->count() > 0)
                        <div class="row">
                            @foreach($profiles as $profile)
                                <div class="col-md-6 mb-3">
                                    <div class="card" style="border-left: 5px solid {{ $profile->color }}">
                                        <div class="card-body">
                                            <form action="{{ route('profiles.update', $profile) }}" method="POST" class="mb-2">
                                                @csrf
                                                @method('PUT')
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <input type="text" name="name" class="form-control"
                                                               value="{{ $profile->name }}" required>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="color" name="color" class="form-control form-control-color"
                                                               value="{{ $profile->color }}" title="Choisir une couleur">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <button type="submit" class="btn btn-success btn-sm w-100">
                                                            {{ __('Modifier') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>

                                            <form action="{{ route('profiles.destroy', $profile) }}" method="POST" class="mt-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm w-100"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce profil ?')">
                                                    {{ __('Supprimer') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('Aucun profil n\'a été créé pour le moment.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
