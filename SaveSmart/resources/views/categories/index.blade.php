@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Catégories</h5>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">Nouvelle Catégorie</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Type</th>
                                    <th>Couleur</th>
                                    <th>Nombre de transactions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $categorie)
                                    <tr>
                                        <td>{{ $categorie->nom }}</td>
                                        <td>
                                            <span class="badge {{ $categorie->type === 'revenu' ? 'bg-success' : 'bg-danger' }}">
                                                {{ ucfirst($categorie->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="color-preview me-2" 
                                                     style="width: 20px; height: 20px; background-color: {{ $categorie->couleur }}; border-radius: 4px;">
                                                </div>
                                                {{ $categorie->couleur }}
                                            </div>
                                        </td>
                                        <td>{{ $categorie->transactions_count }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('categories.edit', $categorie) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    Modifier
                                                </a>
                                                <form action="{{ route('categories.destroy', $categorie) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-outline-danger" 
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Aucune catégorie trouvée</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
