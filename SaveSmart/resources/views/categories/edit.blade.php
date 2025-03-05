@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="py-4 px-6 bg-gray-50 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Modifier la catégorie</h1>
        </div>

        <form action="{{ route('categories.update', $category) }}" method="POST" class="py-4 px-6">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" value="{{ $category->name }}" required>
            </div>
            <div class="mb-4">
                <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type" name="type" required>
                    <option value="income" {{ $category->type === 'income' ? 'selected' : '' }}>Revenu</option>
                    <option value="expense" {{ $category->type === 'expense' ? 'selected' : '' }}>Dépense</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="color" class="block text-gray-700 text-sm font-bold mb-2">Couleur</label>
                <input type="color" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="color" name="color" value="{{ $category->color }}" required>
            </div>
            <div class="mb-4" id="budget-type-group" style="{{ $category->type === 'expense' ? 'display: block;' : 'display: none;' }}">
                <label for="budget_type" class="block text-gray-700 text-sm font-bold mb-2">Type de budget</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="budget_type" name="budget_type">
                    <option value="">Sélectionnez un type</option>
                    <option value="needs" {{ $category->budget_type === 'needs' ? 'selected' : '' }}>Besoins</option>
                    <option value="wants" {{ $category->budget_type === 'wants' ? 'selected' : '' }}>Envies</option>
                    <option value="savings" {{ $category->budget_type === 'savings' ? 'selected' : '' }}>Épargne</option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('type').addEventListener('change', function() {
    var budgetTypeGroup = document.getElementById('budget-type-group');
    if (this.value === 'expense') {
        budgetTypeGroup.style.display = 'block';
    } else {
        budgetTypeGroup.style.display = 'none';
    }
});
</script>
@endsection

