<?php
// app/Http/Controllers/Comptable/LitigeController.php

namespace App\Http\Controllers\Comptable;

use App\Http\Controllers\Controller;
use App\Models\Litige;
use Illuminate\Http\Request;

class LitigeController extends Controller
{
    /**
     * Afficher la liste des litiges
     */
    public function index()
    {
        $litiges = Litige::with(['paiement.parent', 'paiement.eleve', 'traiteur'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        $stats = [
            'ouverts' => Litige::where('statut', 'ouvert')->count(),
            'en_cours' => Litige::where('statut', 'en_cours')->count(),
            'resolus' => Litige::where('statut', 'resolu')->count(),
        ];
        
        return view('comptable.litiges.index', compact('litiges', 'stats'));
    }
    
    /**
     * Afficher un litige spécifique
     */
    public function show($id)
    {
        $litige = Litige::with(['paiement.parent', 'paiement.eleve', 'traiteur'])->findOrFail($id);
        return view('comptable.litiges.show', compact('litige'));
    }
    
    /**
     * Afficher le formulaire d'édition
     */
    public function edit($id)
    {
        $litige = Litige::findOrFail($id);
        return view('comptable.litiges.edit', compact('litige'));
    }
    
    /**
     * Mettre à jour un litige
     */
    public function update(Request $request, $id)
    {
        $litige = Litige::findOrFail($id);
        
        $validated = $request->validate([
            'statut' => 'required|in:ouvert,en_cours,resolu,rejete',
            'solution' => 'nullable|string',
        ]);
        
        $validated['date_resolution'] = in_array($validated['statut'], ['resolu', 'rejete']) ? now() : null;
        $validated['traite_par'] = auth()->id();
        
        $litige->update($validated);
        
        return redirect()->route('comptable.litiges.show', $litige->id_litige)
            ->with('success', 'Litige mis à jour avec succès.');
    }
}