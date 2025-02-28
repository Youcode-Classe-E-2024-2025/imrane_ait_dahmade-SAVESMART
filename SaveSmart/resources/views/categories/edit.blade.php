@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Modifier la Catégorie</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('categories.update', $categorie) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de la catégorie</label>
                            <input type="text" 
                                   class="form-control @error('nom') is-invalid @enderror" 
                                   id="nom" 
                                   name="nom" 
                                   value="{{ old('nom', $categorie->nom) }}" 
                                   required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" 
                                    name="type" 
                                    required>
                                <option value="">Sélectionnez un type</option>
                                <option value="revenu" {{ old('type', $categorie->type) === 'revenu' ? 'selected' : '' }}>Revenu</option>
                                <option value="depense" {{ old('type', $categorie->type) === 'depense' ? 'selected' : '' }}>Dépense</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="couleur" class="form-label">Couleur</label>
                            <input type="color" 
                                   class="form-control form-control-color @error('couleur') is-invalid @enderror" 
                                   id="couleur" 
                                   name="couleur" 
                                   value="{{ old('couleur', $categorie->couleur) }}" 
                                   title="Choisir une couleur"
                                   required>
                            @error('couleur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Mettre à jour la catégorie
                            </button>
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
