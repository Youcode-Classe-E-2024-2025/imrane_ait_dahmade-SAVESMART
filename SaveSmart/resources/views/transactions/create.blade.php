@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Nouvelle Transaction</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('transactions.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="type" class="form-label">Type de transaction</label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" 
                                    name="type" 
                                    required>
                                <option value="">Sélectionnez un type</option>
                                <option value="revenu" {{ old('type') === 'revenu' ? 'selected' : '' }}>Revenu</option>
                                <option value="depense" {{ old('type') === 'depense' ? 'selected' : '' }}>Dépense</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="montant" class="form-label">Montant</label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('montant') is-invalid @enderror" 
                                       id="montant" 
                                       name="montant" 
                                       value="{{ old('montant') }}" 
                                       step="0.01" 
                                       min="0" 
                                       required>
                                <span class="input-group-text">€</span>
                                @error('montant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" 
                                   class="form-control @error('description') is-invalid @enderror" 
                                   id="description" 
                                   name="description" 
                                   value="{{ old('description') }}" 
                                   required>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" 
                                   class="form-control @error('date') is-invalid @enderror" 
                                   id="date" 
                                   name="date" 
                                   value="{{ old('date', date('Y-m-d')) }}" 
                                   required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="categorie_id" class="form-label">Catégorie</label>
                            <select class="form-select @error('categorie_id') is-invalid @enderror" 
                                    id="categorie_id" 
                                    name="categorie_id" 
                                    required>
                                <option value="">Sélectionnez une catégorie</option>
                                @foreach($categories as $categorie)
                                    <option value="{{ $categorie->id }}" 
                                            {{ old('categorie_id') == $categorie->id ? 'selected' : '' }}
                                            data-type="{{ $categorie->type }}"
                                            data-color="{{ $categorie->color }}"
                                            data-icon="{{ $categorie->icon }}">
                                        {{ $categorie->icon }} {{ $categorie->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categorie_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Créer la transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const categorieSelect = document.getElementById('categorie_id');
    const originalOptions = Array.from(categorieSelect.options);

    function filterCategories() {
        const selectedType = typeSelect.value;
        
        // Réinitialiser les options
        categorieSelect.innerHTML = '';
        categorieSelect.appendChild(originalOptions[0].cloneNode(true));

        // Filtrer les catégories selon le type sélectionné
        if (selectedType) {
            originalOptions.forEach(option => {
                if (option.value && option.dataset.type === selectedType) {
                    const newOption = option.cloneNode(true);
                    // Appliquer la couleur de fond et l'icône
                    if (newOption.dataset.color) {
                        newOption.style.backgroundColor = newOption.dataset.color;
                        newOption.style.color = '#ffffff';
                    }
                    categorieSelect.appendChild(newOption);
                }
            });
        }
    }

    typeSelect.addEventListener('change', filterCategories);
    
    // Appliquer le filtre au chargement si un type est déjà sélectionné
    if (typeSelect.value) {
        filterCategories();
    }
});
</script>
@endpush
