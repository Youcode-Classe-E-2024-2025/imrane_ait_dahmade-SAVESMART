@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Tableau de bord</h1>
    
    <!-- Debug Information -->
    @if(config('app.debug'))
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
        <p class="font-bold">Debug Information:</p>
        <p>Income: {{ $income }}</p>
        <p>Expenses: {{ $expenses }}</p>
        <p>Balance: {{ $balance }}</p>
        <p>Budget Plan: {{ json_encode($budgetPlan) }}</p>
        <p>Category Spending: {{ json_encode($categorySpending) }}</p>
        <p>Goals: {{ json_encode($goals) }}</p>
    </div>
    @endif
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Résumé financier -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Résumé du mois</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Revenus</span>
                    <span class="font-medium text-green-600">{{ number_format($income, 2) }} €</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Dépenses</span>
                    <span class="font-medium text-red-600">{{ number_format($expenses, 2) }} €</span>
                </div>
                <div class="border-t pt-2 flex justify-between items-center">
                    <span class="font-semibold">Solde</span>
                    <span class="font-bold {{ $balance >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ number_format($balance, 2) }} €
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Répartition 50/30/20 -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Budget 50/30/20</h2>
            <div class="space-y-4">
                @foreach($budgetPlan as $type => $data)
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-gray-600">{{ ucfirst($type) }} ({{ $data['percentage'] }}%)</span>
                            <span class="font-medium">{{ number_format($data['amount'], 2) }} €</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="h-2.5 rounded-full" style="width: {{ $data['percentage'] }}%; background-color: 
                                @if($type == 'needs') #3B82F6
                                @elseif($type == 'wants') #8B5CF6
                                @else #10B981
                                @endif
                            "></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Actions rapides -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Actions rapides</h2>
            <div class="space-y-3">
                <a href="{{ route('transactions.create') }}" class="block w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-center transition">
                    Ajouter une transaction
                </a>
                <a href="{{ route('goals.create') }}" class="block w-full py-2 px-4 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-center transition">
                    Créer un objectif
                </a>
                <a href="{{ route('transactions.index') }}" class="block w-full py-2 px-4 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg text-center transition">
                    Voir toutes les transactions
                </a>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Dépenses par catégorie -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Dépenses par catégorie</h2>
            @if(count($categorySpending) > 0)
                <div class="space-y-4">
                    @foreach($categorySpending as $category)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-gray-600">{{ $category['name'] }}</span>
                                <span class="font-medium">{{ number_format($category['amount'], 2) }} € ({{ $category['percentage'] }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full" style="width: {{ $category['percentage'] }}%; background-color: {{ $category['color'] }}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">Aucune dépense enregistrée ce mois-ci.</p>
            @endif
        </div>
        
        <!-- Objectifs d'épargne -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Objectifs d'épargne</h2>
            @if(count($goals) > 0)
                <div class="space-y-6">
                    @foreach($goals as $goal)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-medium">{{ $goal->name }}</span>
                                <span class="text-sm text-gray-500">Échéance: {{ $goal->deadline->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-gray-600">{{ number_format($goal->current_amount, 2) }} € / {{ number_format($goal->target_amount, 2) }} €</span>
                                <span class="font-medium">{{ $goal->getProgressPercentage() }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $goal->getProgressPercentage() }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">Aucun objectif d'épargne défini.</p>
                <div class="mt-4">
                    <a href="{{ route('goals.create') }}" class="inline-block py-2 px-4 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-center transition">
                        Créer un objectif
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

