@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Ma Famille</h1>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if($family)
        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
            <div class="py-4 px-6 bg-gray-50 border-b">
                <h2 class="text-xl font-semibold text-gray-800">{{ $family->name }}</h2>
            </div>
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Membres :</h3>
                <ul class="space-y-2">
                    @foreach($members as $member)
                        <li class="flex items-center justify-between">
                            <span>{{ $member->name }} ({{ $member->email }})</span>
                            @if(Auth::user()->is_family_admin && $member->id !== Auth::id())
                                <form action="{{ route('families.remove-member', $member) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm font-bold py-1 px-2 rounded focus:outline-none focus:shadow-outline" onclick="return confirm('Êtes-vous sûr de vouloir retirer ce membre ?')">
                                        Retirer
                                    </button>
                                </form>
                            @endif
                        </li>
                    @endforeach
                </ul>
                @if(Auth::user()->is_family_admin)
                    <div class="mt-6">
                        <a href="{{ route('families.add-member') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Ajouter un membre
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6">
                <p class="text-gray-700 mb-4">Vous n'avez pas encore de famille.</p>
                <a href="{{ route('families.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Créer une famille
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

