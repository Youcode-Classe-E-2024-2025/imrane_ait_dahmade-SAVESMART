@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Modifier la Transaction</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('transactions.update', $transaction) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="type" class="form-label">Type de transaction</label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" 
                                    name="type" 
                                    required>
                                <option value="">Sélectionnez un type</option>
                                <option value="revenu" {{ old('type', $transaction->type) === 'revenu' ? 'selected' : '' }}>Revenu</option>
                                <option value="depense" {{ old('type', $transaction->type) === 'depense' ? 'selected' : '' }}>Dépense</option>
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
                                       value="{{ old('montant', $transaction->montant) }}" 
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
                                   value="{{ old('description', $transaction->description) }}" 
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
                                   value="{{ old('date', $transaction->date->format('Y-m-d')) }}" 
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
                                            {{ old('categorie_id', $transaction->categorie_id) == $categorie->id ? 'selected' : '' }}
                                            data-type="{{ $categorie->type }}"
                                            style="background-color: {{ $categorie->couleur }}">
                                        {{ $categorie->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categorie_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Mettre à jour la transaction
                            </button>
                            <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const categorieSelect = document.getElementById('categorie_id');
    
    function filterCategories() {
        const selectedType = typeSelect.value;
        const options = categorieSelect.options;
        
        for (let i = 1; i < options.length; i++) {
            const option = options[i];
            const categorieType = option.getAttribute('data-type');
            
            if (selectedType === '' || categorieType === selectedType) {
                option.style.display = '';
            } else {
                option.style.display = 'none';
            }
        }
        
        // Reset categorie selection if current selection is not valid
        if (categorieSelect.selectedIndex > 0) {
            const selectedOption = options[categorieSelect.selectedIndex];
            const selectedType = selectedOption.getAttribute('data-type');
            if (selectedType !== typeSelect.value) {
                categorieSelect.selectedIndex = 0;
            }
        }
    }
    
    typeSelect.addEventListener('change', filterCategories);
    filterCategories();
});
</script>
@endpush
@endsection
