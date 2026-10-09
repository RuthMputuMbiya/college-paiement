<?php
// app/Http/Controllers/Eleve/ProfileController.php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Afficher le profil de l'élève
     */
    public function index()
    {
        $eleve = Eleve::find(session('eleve_id'));
        return view('eleve.profile.index', compact('eleve'));
    }
    
    /**
     * Afficher le formulaire de changement de mot de passe
     */
    public function editPassword()
    {
        $eleve = Eleve::find(session('eleve_id'));
        return view('eleve.profile.change-password', compact('eleve'));
    }
    
    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ], [
            'password.required' => 'Le mot de passe est requis',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
        ]);

        $eleve = Eleve::find(session('eleve_id'));
        
        if (!$eleve) {
            return redirect()->route('eleve.login')->with('error', 'Session expirée.');
        }

        $eleve->mot_de_passe = Hash::make($request->password);
        $eleve->premiere_connexion = false;
        $eleve->save();

        return redirect()->route('eleve.dashboard')
            ->with('success', 'Mot de passe modifié avec succès !');
    }
    
    /**
     * Télécharger un reçu
     */
    public function downloadReceipt($id)
    {
        $paiement = \App\Models\Paiement::findOrFail($id);
        
        if ($paiement->eleve_id != session('eleve_id')) {
            abort(403);
        }
        
        // Génération PDF à implémenter
        return back()->with('info', 'Génération PDF en cours de développement');
    }
}