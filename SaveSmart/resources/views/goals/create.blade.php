@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="py-4 px-6 bg-gray-50 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Créer un nouvel objectif</h1>
        </div>

        <form action="{{ route('goals.store') }}" method="POST" class="py-4 px-6">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom de l'objectif</label>
                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" name="name" required>
            </div>
            <div class="mb-4">
                <label for="target_amount" class="block text-gray-700 text-sm font-bold mb-2">Montant cible</label>
                <input type="number" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="target_amount" name="target_amount" required>
            </div>
            <div class="mb-4">
                <label for="current_amount" class="block text-gray-700 text-sm font-bold mb-2">Montant actuel</label>
                <input type="number" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="current_amount" name="current_amount" required>
            </div>
            <div class="mb-4">
                <label for="deadline" class="block text-gray-700 text-sm font-bold mb-2">Date limite</label>
                <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="deadline" name="deadline" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="description" name="description"></textarea>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Créer l'objectif
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

