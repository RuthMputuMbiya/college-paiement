<?php
// app/Http/Controllers/Parent/ProfileController.php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Afficher le formulaire d'édition du profil
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Statistiques pour le profil
        $enfants = $user->eleves;
        $totalPaye = $user->paiements()->where('statut', 'valide')->sum('montant');
        
        // Calcul du taux de paiement
        $totalAttendu = 0;
        foreach ($enfants as $enfant) {
            $totalAttendu += $enfant->classe->frais->where('statut', 'actif')->sum('montant');
        }
        $tauxPaiement = $totalAttendu > 0 ? round(($totalPaye / $totalAttendu) * 100, 2) : 100;
        
        $stats = [
            'total_enfants' => $enfants->count(),
            'total_paye' => $totalPaye,
            'taux_paiement' => $tauxPaiement,
        ];
        
        return view('parent.profile.edit', compact('stats'));
    }
    
    /**
     * Mettre à jour les informations du profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'string', 'max:20'],
            'adresse' => ['nullable', 'string', 'max:500'],
            'profession' => ['nullable', 'string', 'max:255'],
        ], [
            'name.required' => 'Le nom complet est requis',
            'telephone.required' => 'Le numéro de téléphone est requis',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('parent.profile.edit')
            ->with('success', 'Vos informations ont été mises à jour avec succès.');
    }
    
    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Le mot de passe actuel est requis',
            'current_password.current_password' => 'Le mot de passe actuel est incorrect',
            'password.required' => 'Le nouveau mot de passe est requis',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
        ]);
        
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();
        
        return redirect()->route('parent.profile.edit')
            ->with('success', 'Votre mot de passe a été modifié avec succès.');
    }
}