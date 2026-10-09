<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Eleve;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Vérifier si c'est un élève (table eleves)
        if ($request->role === 'eleve') {
            $eleve = Eleve::where('email', $request->email)->first();
            
            if ($eleve && \Hash::check($request->password, $eleve->mot_de_passe)) {
                if ($eleve->statut !== 'inscrit') {
                    return back()->with('error', 'Votre compte élève est désactivé.');
                }
                
                // Stocker l'élève en session
                session([
                    'eleve_id' => $eleve->id_eleve,
                    'eleve_nom' => $eleve->prenom . ' ' . $eleve->nom,
                    'eleve_email' => $eleve->email
                ]);
                
                // Redirection pour première connexion
                if ($eleve->premiere_connexion) {
                    return redirect()->route('eleve.profile.edit-password')
                        ->with('warning', 'Veuillez changer votre mot de passe avant de continuer.');
                }
                
                return redirect()->intended(route('eleve.dashboard'));
            }
            
            return back()->withErrors(['email' => 'Identifiants incorrects.'])->withInput();
        }
        
        // Connexion pour les autres utilisateurs (table users)
        $request->authenticate();
        $request->session()->regenerate();
        
        $user = Auth::user();
        
        // Vérifier le rôle sélectionné
        if ($request->has('role') && $user->role !== $request->role) {
            Auth::logout();
            return back()->with('error', 'Rôle incorrect. Veuillez sélectionner le bon rôle.')
                         ->withInput();
        }
        
        // Vérifier si le compte est actif
        if ($user->statut !== 'actif') {
            Auth::logout();
            return back()->with('error', 'Votre compte est désactivé. Veuillez contacter le gestionnaire système.');
        }
        
        // Mettre à jour la dernière connexion
        $user->update(['last_login_at' => now()]);
        
        // Redirection selon le rôle
        if ($user->role === 'gestionnaire_systeme') {
            return redirect()->intended(route('gestionnaire.dashboard'));
        }
        
        if ($user->role === 'comptable') {
            return redirect()->intended(route('comptable.dashboard'));
        }
        
        if ($user->role === 'parent') {
            return redirect()->intended(route('parent.dashboard'));
        }
        
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Déconnexion élève
        if (session()->has('eleve_id')) {
            session()->forget(['eleve_id', 'eleve_nom', 'eleve_email']);
            return redirect('/')->with('success', 'Déconnexion réussie.');
        }
        
        // Déconnexion utilisateur normal
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Déconnexion réussie.');
    }
}