@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Connexion</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password" required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        @if(session()->has('profiles') && !empty(session('profiles')))
                        <div class="mb-3">
                            <label for="profile_id" class="form-label">Choisir un Profil</label>
                            <select class="form-select @error('profile_id') is-invalid @enderror" 
                                    id="profile_id" name="profile_id" required>
                                <option value="">{{ __('Sélectionnez un profil') }}</option>
                                @foreach(session('profiles') as $profile)
                                    <option value="{{ $profile->id }}" 
                                            style="background-color: {{ $profile->color }}">
                                        {{ $profile->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('profile_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Se souvenir de moi</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Se connecter</button>
                            <a href="{{ route('register') }}" class="btn btn-link text-center">Pas encore inscrit ? Créer un compte</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
