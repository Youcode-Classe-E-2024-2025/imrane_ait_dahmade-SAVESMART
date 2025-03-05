@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Objectifs d'épargne</h1>
        <a href="{{ route('goals.create') }}" class="py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-center transition">
            Ajouter un objectif
        </a>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($goals as $goal)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-xl font-semibold">{{ $goal->name }}</h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('goals.edit', $goal) }}" class="text-blue-600 hover:text-blue-900">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('goals.destroy', $goal) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet objectif ?')">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    @if($goal->description)
                        <p class="text-gray-600 mb-4">{{ $goal->description }}</p>
                    @endif
                    
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm text-gray-500">Progression</span>
                            <span class="text-sm font-medium">{{ $goal->getProgressPercentage() }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $goal->getProgressPercentage() }}%"></div>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Montant actuel</p>
                            <p class="text-lg font-semibold">{{ number_format($goal->current_amount, 2) }} €</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Objectif</p>
                            <p class="text-lg font-semibold">{{ number_format($goal->target_amount, 2) }} €</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500">Échéance</p>
                        <p class="font-medium">{{ $goal->deadline->format('d/m/Y') }}</p>
                    </div>
                    
                    <form action="{{ route('goals.updateAmount', $goal) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="flex space-x-2">
                            <input type="number" name="amount" class="form-input flex-1" step="0.01" min="0" value="{{ $goal->current_amount }}" required>
                            <button type="submit" class="py-2 px-4 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-center transition">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg shadow p-6 text-center">
                <p class="text-gray-500 mb-4">Vous n'avez pas encore créé d'objectif d'épargne.</p>
                <a href="{{ route('goals.create') }}" class="inline-block py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-center transition">
                    Créer votre premier objectif
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection

