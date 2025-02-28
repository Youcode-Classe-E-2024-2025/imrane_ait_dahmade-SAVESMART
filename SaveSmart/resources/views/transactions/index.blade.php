@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Résumé</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Revenus</h6>
                                    <h4 class="card-text">{{ number_format($revenus, 2) }} €</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Dépenses</h6>
                                    <h4 class="card-text">{{ number_format($depenses, 2) }} €</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card {{ $solde >= 0 ? 'bg-primary' : 'bg-warning' }} text-white">
                                <div class="card-body">
                                    <h6 class="card-title">Solde</h6>
                                    <h4 class="card-text">{{ number_format($solde, 2) }} €</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Transactions</h5>
                    <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                        Nouvelle Transaction
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($transactions->isEmpty())
                        <div class="alert alert-info">
                            Aucune transaction enregistrée.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Catégorie</th>
                                        <th>Description</th>
                                        <th>Montant</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->date->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge {{ $transaction->type === 'revenu' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ ucfirst($transaction->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge" style="background-color: {{ $transaction->categorie->color }}">
                                                    {{ $transaction->categorie->icon }} {{ $transaction->categorie->name }}
                                                </span>
                                            </td>
                                            <td>{{ $transaction->description }}</td>
                                            <td>{{ number_format($transaction->montant, 2) }} €</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('transactions.edit', $transaction) }}" 
                                                       class="btn btn-sm btn-outline-primary">
                                                        Modifier
                                                    </a>
                                                    <form action="{{ route('transactions.destroy', $transaction) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-outline-danger"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette transaction ?')">
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
