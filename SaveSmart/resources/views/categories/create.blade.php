@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="py-4 px-6 bg-gray-50 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Créer une nouvelle catégorie</h1>
        </div>

        <form action="{{ route('categories.store') }}" method="POST" class="py-4 px-6">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" required>
            </div>
            <div class="mb-4">
                <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="type" name="type" required>
                    <option value="income">Revenu</option>
                    <option value="expense">Dépense</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="color" class="block text-gray-700 text-sm font-bold mb-2">Couleur</label>
                <input type="color" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="color" name="color" required>
            </div>
            <div class="mb-4" id="budget-type-group" style="display: none;">
                <label for="budget_type" class="block text-gray-700 text-sm font-bold mb-2">Type de budget</label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="budget_type" name="budget_type">
                    <option value="">Sélectionnez un type</option>
                    <option value="needs">Besoins</option>
                    <option value="wants">Envies</option>
                    <option value="savings">Épargne</option>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Créer
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

