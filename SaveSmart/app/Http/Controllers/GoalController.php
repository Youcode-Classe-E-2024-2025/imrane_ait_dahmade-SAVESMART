<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $goals = Goal::where('user_id', $user->id)
            ->orderBy('deadline')
            ->get();
        
        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('goals.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'target_amount' => 'required|numeric|min:1',
            'current_amount' => 'required|numeric|min:0',
            'deadline' => 'required|date|after:today',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
        ]);
        
        $validated['user_id'] = Auth::id();
        
        Goal::create($validated);
        
        return redirect()->route('goals.index')
            ->with('success', 'Objectif créé avec succès.');
    }

    public function edit(Goal $goal)
    {
        $this->authorize('update', $goal);
        
        return view('goals.edit', compact('goal'));
    }

    public function update(Request $request, Goal $goal)
    {
        $this->authorize('update', $goal);
        
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'target_amount' => 'required|numeric|min:1',
            'current_amount' => 'required|numeric|min:0',
            'deadline' => 'required|date|after:today',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
        ]);
        
        $goal->update($validated);
        
        return redirect()->route('goals.index')
            ->with('success', 'Objectif mis à jour avec succès.');
    }

    public function destroy(Goal $goal)
    {
        $this->authorize('delete', $goal);
        
        $goal->delete();
        
        return redirect()->route('goals.index')
            ->with('success', 'Objectif supprimé avec succès.');
    }

    public function updateAmount(Request $request, Goal $goal)
    {
        $this->authorize('update', $goal);
        
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);
        
        $goal->current_amount = $validated['amount'];
        $goal->save();
        
        return redirect()->route('goals.index')
            ->with('success', 'Montant mis à jour avec succès.');
    }
}

