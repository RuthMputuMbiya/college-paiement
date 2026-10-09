<?php
// app/Http/Controllers/Comptable/ClasseController.php

namespace App\Http\Controllers\Comptable;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Eleve;
use Illuminate\Http\Request;

class ClasseController extends Controller
{
    public function index(Request $request)
    {
        $query = Classe::query();
        
        if ($request->filled('search')) {
            $query->where('nom_classe', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('niveau')) {
            $query->where('niveau', $request->niveau);
        }
        
        if ($request->filled('annee_scolaire')) {
            $query->where('annee_scolaire', $request->annee_scolaire);
        }
        
        $classes = $query->orderBy('nom_classe')->paginate(15);
        
        $totalEleves = Eleve::count();
        $moyenneParClasse = $classes->count() > 0 ? round($totalEleves / $classes->count(), 1) : 0;
        
        return view('comptable.classes.index', compact('classes', 'totalEleves', 'moyenneParClasse'));
    }

    public function create()
    {
        return view('comptable.classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_classe' => 'required|string|max:50|unique:classes',
            'niveau' => 'required|string|max:30',
            'annee_scolaire' => 'required|string|max:20',
            'capacite' => 'required|integer|min:1|max:100',
            'description' => 'nullable|string',
        ]);
        
        $validated['effectif'] = 0;
        
        $classe = Classe::create($validated);
        
        return redirect()->route('comptable.classes.index')
            ->with('success', "Classe {$classe->nom_classe} créée avec succès.");
    }

    public function show($id)
    {
        $classe = Classe::with(['eleves', 'frais'])->findOrFail($id);
        return view('comptable.classes.show', compact('classe'));
    }

    public function edit($id)
    {
        $classe = Classe::findOrFail($id);
        return view('comptable.classes.edit', compact('classe'));
    }

    public function update(Request $request, $id)
    {
        $classe = Classe::findOrFail($id);
        
        $validated = $request->validate([
            'nom_classe' => 'required|string|max:50|unique:classes,nom_classe,' . $id . ',id_classe',
            'niveau' => 'required|string|max:30',
            'annee_scolaire' => 'required|string|max:20',
            'capacite' => 'required|integer|min:1|max:100',
            'description' => 'nullable|string',
        ]);
        
        if ($validated['capacite'] < $classe->effectif) {
            return back()->with('error', 'La capacité ne peut pas être inférieure à l\'effectif actuel (' . $classe->effectif . ' élèves).');
        }
        
        $classe->update($validated);
        
        return redirect()->route('comptable.classes.index')
            ->with('success', "Classe {$classe->nom_classe} mise à jour.");
    }

    public function destroy($id)
    {
        $classe = Classe::findOrFail($id);
        $nom = $classe->nom_classe;
        
        if ($classe->eleves()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer une classe qui contient des élèves.');
        }
        
        $classe->delete();
        
        return redirect()->route('comptable.classes.index')
            ->with('success', "Classe {$nom} supprimée.");
    }
}