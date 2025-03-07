@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Objectifs d'épargne</h1>
        <a href="{{ route('goals.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
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
                    <h2 class="text-xl font-semibold mb-2">{{ $goal->name }}</h2>
                    <p class="text-gray-600 mb-4">{{ $goal->description }}</p>
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm text-gray-500">Progression</span>
                            <span class="text-sm font-medium">{{ $goal->getProgressPercentage() }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $goal->getProgressPercentage() }}%"></div>
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
                    <p class="text-sm text-gray-500 mb-4">Échéance : {{ $goal->deadline->format('d/m/Y') }}</p>
                    <div class="flex justify-between">
                        <a href="{{ route('goals.edit', $goal) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">Modifier</a>
                        <form action="{{ route('goals.destroy', $goal) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet objectif ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg shadow p-6 text-center">
                <p class="text-gray-500 mb-4">Vous n'avez pas encore créé d'objectif d'épargne.</p>
                <a href="{{ route('goals.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Créer votre premier objectif
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection

