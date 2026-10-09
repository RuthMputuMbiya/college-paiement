<?php
// app/Http/Controllers/Comptable/FraisController.php

namespace App\Http\Controllers\Comptable;

use App\Http\Controllers\Controller;
use App\Models\Frais;
use App\Models\Classe;
use App\Models\Paiement;
use Illuminate\Http\Request;

class FraisController extends Controller
{
    public function index(Request $request)
    {
        $query = Frais::with('classe');
        
        if ($request->filled('search')) {
            $query->where('libelle', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }
        
        if ($request->filled('devise')) {
            $query->where('devise', $request->devise);
        }
        
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        
        $frais = $query->orderBy('created_at', 'desc')->paginate(15);
        $classes = Classe::all();
        
        $stats = [
            'actifs' => Frais::where('statut', 'actif')->count(),
            'total_classes' => Classe::count(),
        ];
        
        return view('comptable.frais.index', compact('frais', 'classes', 'stats'));
    }

    public function create()
    {
        $classes = Classe::all();
        return view('comptable.frais.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'libelle' => 'required|string|max:100',
            'description' => 'nullable|string',
            'montant' => 'required|numeric|min:0',  // Pas de limite max, seulement min 0
            'devise' => 'required|in:FC,USD',
            'penalite' => 'nullable|numeric|min:0',
            'date_echeance' => 'required|date',
            'periodicite' => 'required|in:mensuel,trimestriel,semestriel,annuel',
            'statut' => 'required|in:actif,inactif',
            'classe_id' => 'required|exists:classes,id_classe',
        ]);
        
        $validated['penalite'] = $validated['penalite'] ?? 0;
        
        $frais = Frais::create($validated);
        
        return redirect()->route('comptable.frais.index')
            ->with('success', "Frais {$frais->libelle} créé avec succès.");
    }

    public function show($id)
    {
        $frais = Frais::with('classe')->findOrFail($id);
        
        $totalPaye = Paiement::where('frais_id', $id)
            ->where('statut', 'valide')
            ->sum('montant');
        
        $montantAttendu = $frais->montant * ($frais->classe->effectif ?? 0);
        $tauxRecouvrement = $montantAttendu > 0 ? round(($totalPaye / $montantAttendu) * 100, 2) : 0;
        
        return view('comptable.frais.show', compact('frais', 'totalPaye', 'tauxRecouvrement'));
    }

    public function edit($id)
    {
        $frais = Frais::findOrFail($id);
        $classes = Classe::all();
        return view('comptable.frais.edit', compact('frais', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $frais = Frais::findOrFail($id);
        
        $validated = $request->validate([
            'libelle' => 'required|string|max:100',
            'description' => 'nullable|string',
            'montant' => 'required|numeric|min:0',  // Pas de limite max, seulement min 0
            'devise' => 'required|in:FC,USD',
            'penalite' => 'nullable|numeric|min:0',
            'date_echeance' => 'required|date',
            'periodicite' => 'required|in:mensuel,trimestriel,semestriel,annuel',
            'statut' => 'required|in:actif,inactif',
            'classe_id' => 'required|exists:classes,id_classe',
        ]);
        
        $validated['penalite'] = $validated['penalite'] ?? 0;
        $frais->update($validated);
        
        return redirect()->route('comptable.frais.index')
            ->with('success', "Frais {$frais->libelle} mis à jour.");
    }

    public function destroy($id)
    {
        $frais = Frais::findOrFail($id);
        $libelle = $frais->libelle;
        
        if ($frais->paiements()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer un frais qui a des paiements associés.');
        }
        
        $frais->delete();
        
        return redirect()->route('comptable.frais.index')
            ->with('success', "Frais {$libelle} supprimé.");
    }
}