@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="py-4 px-6 bg-gray-50 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Ajouter une transaction</h1>
        </div>

        <form action="{{ route('transactions.store') }}" method="POST" class="py-4 px-6">
            @csrf
            
            <div class="mb-4">
                <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type de transaction</label>
                <select name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="income">Revenu</option>
                    <option value="expense">Dépense</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Catégorie</label>
                <select name="category_id" id="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="">Sélectionnez une catégorie</option>
                    <optgroup label="Revenus" id="income-categories">
                        @foreach($incomeCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label="Dépenses" id="expense-categories" style="display: none;">
                        @foreach($expenseCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>
            
            <div class="mb-4">
                <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Montant</label>
                <input type="number" name="amount" id="amount" step="0.01" min="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description (optionnel)</label>
                <input type="text" name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            
            <div class="mb-6">
                <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date</label>
                <input type="date" name="date" id="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Ajouter la transaction
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const categorySelect = document.getElementById('category_id');
    const incomeCategories = document.getElementById('income-categories');
    const expenseCategories = document.getElementById('expense-categories');

    typeSelect.addEventListener('change', function() {
        if (this.value === 'income') {
            incomeCategories.style.display = 'block';
            expenseCategories.style.display = 'none';
        } else {
            incomeCategories.style.display = 'none';
            expenseCategories.style.display = 'block';
        }
        categorySelect.value = ''; // Reset category selection
    });
});
</script>
@endsection

