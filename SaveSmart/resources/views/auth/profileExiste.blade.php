<div class="container mt-5">
    <h1 class="text-danger">NETFLIX</h1>
    <h3 class="my-3">Qui est-ce ?</h3>
    <div class="row justify-content-center">
        @foreach($profiles as $profile)
            <div class="col-3 text-center">
                <div class="profile" style="background-color: {{ $profile->color }}">
                    <img src="https://via.placeholder.com/100" alt="Profile">
                </div>
                <p>{{ $profile->name }}</p>
            </div>
        @endforeach
        <div class="col-3 text-center">
            <div class="profile bg-dark" data-bs-toggle="modal" data-bs-target="#addProfileModal">
                <h2>+</h2>
            </div>
            <p>Ajouter un profil</p>
        </div>
    </div>
</div>

<!-- Modal d'ajout -->
<div class="modal fade" id="addProfileModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un profil</h5>
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
                        <input type="color" name="color" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>