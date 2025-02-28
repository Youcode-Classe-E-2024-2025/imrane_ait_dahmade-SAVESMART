@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <!-- Card du profil utilisateur -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->email }}&background=random" 
                             class="rounded-circle img-fluid" style="width: 150px;">
                    </div>
                    <h5 class="mb-3">{{ auth()->user()->email }}</h5>
                    <p class="text-muted mb-4">Membre depuis {{ auth()->user()->created_at ? auth()->user()->created_at->format('d/m/Y') : 'N/A' }}</p>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Card des profils -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Mes Profils</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addProfileModal">
                        <i class="fas fa-plus"></i> Nouveau Profil
                    </button>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(count($profiles) > 0)
                        <div class="row g-4">
                            @foreach($profiles as $profile)
                                <div class="col-md-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-body text-center">
                                            <div class="rounded-circle mx-auto mb-3" 
                                                 style="width: 80px; height: 80px; background-color: {{ $profile->color }}">
                                            </div>
                                            <h6 class="card-title mb-2">{{ $profile->name }}</h6>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary" data-bs-toggle="modal" 
                                                        data-bs-target="#editProfileModal{{ $profile->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger" 
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce profil ?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal de modification pour chaque profil -->
                                <div class="modal fade" id="editProfileModal{{ $profile->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header border-0">
                                                <h5 class="modal-title">Modifier le profil</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('profiles.update', $profile->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label class="form-label">Nom du profil</label>
                                                        <input type="text" name="name" class="form-control" 
                                                               value="{{ $profile->name }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Couleur</label>
                                                        <input type="color" name="color" class="form-control form-control-color w-100" 
                                                               value="{{ $profile->color }}" required>
                                                    </div>
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <img src="https://img.icons8.com/clouds/100/000000/user-group-man-woman.png" class="mb-3" alt="No Profiles">
                            <h6 class="text-muted">Vous n'avez pas encore créé de profil</h6>
                            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addProfileModal">
                                <i class="fas fa-plus"></i> Créer mon premier profil
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'ajout de profil -->
<div class="modal fade" id="addProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">Créer un nouveau profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profiles.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nom du profil</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Couleur</label>
                        <input type="color" name="color" class="form-control form-control-color w-100" required>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Créer le profil</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    border: none;
}

.btn {
    border-radius: 8px;
}

.modal-content {
    border-radius: 15px;
    border: none;
}

.form-control {
    border-radius: 8px;
    padding: 0.75rem 1rem;
}

.form-control:focus {
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,.15);
}

.alert {
    border-radius: 10px;
}
</style>
@endsection