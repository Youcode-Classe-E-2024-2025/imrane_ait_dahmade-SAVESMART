@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b">
            <h1 class="text-xl font-bold text-gray-700">Inscription</h1>
        </div>
        
        <form method="POST" action="{{ route('register') }}" class="p-6">
            @csrf
            
            <div class="mb-6">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nom</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                    class="form-input w-full @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Adresse e-mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                    class="form-input w-full @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
                <input id="password" type="password" name="password" required 
                    class="form-input w-full @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirmer le mot de passe</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required 
                    class="form-input w-full">
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-center transition">
                    S'inscrire
                </button>
                
                <a class="text-sm text-blue-600 hover:text-blue-800" href="{{ route('login') }}">
                    Déjà inscrit ?
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

