@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Inscription</h2>

    <form action="{{ route('register') }}" method="POST">
        @csrf
        
    
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmez le mot de passe</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">S'inscrire</button>
        <a href="{{ route('login') }}" class="btn btn-link">Déjà inscrit ? Se connecter</a>
    </form>
</div>
@endsection
