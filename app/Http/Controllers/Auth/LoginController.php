<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Traiter la demande de connexion
     */
    public function login(Request $request)
    {
        // Validation des champs (sans rôle)
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'L\'adresse email est requise',
            'password.required' => 'Le mot de passe est requis',
        ]);

        // 1. Vérifier d'abord si c'est un élève (table eleves)
        $eleve = Eleve::where('email', $request->email)->first();
        
        if ($eleve && Hash::check($request->password, $eleve->mot_de_passe)) {
            return $this->loginEleve($eleve, $request);
        }

        // 2. Sinon, vérifier si c'est un utilisateur (table users)
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            return $this->loginUser($user, $request);
        }

        // 3. Si aucun compte trouvé
        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.'])->withInput();
    }

    /**
     * Connexion pour les élèves
     */
    protected function loginEleve($eleve, Request $request)
    {
        Log::info('Connexion élève', [
            'email' => $eleve->email,
            'nom' => $eleve->prenom . ' ' . $eleve->nom,
        ]);

        if ($eleve->statut !== 'inscrit') {
            return back()->with('error', 'Votre compte élève est désactivé. Veuillez contacter l\'administration.');
        }

        session([
            'eleve_id'    => $eleve->id_eleve,
            'eleve_nom'   => $eleve->prenom . ' ' . $eleve->nom,
            'eleve_email' => $eleve->email,
            'eleve_role'  => 'eleve',
            'is_eleve'    => true,
        ]);

        $eleve->update(['last_login_at' => now()]);

        if ($eleve->premiere_connexion) {
            return redirect()->route('eleve.profile.edit-password')
                ->with('warning', 'Bienvenue ! Veuillez changer votre mot de passe avant de continuer.');
        }

        return redirect()->route('eleve.dashboard')
            ->with('success', 'Bienvenue ' . $eleve->prenom . ' !');
    }

    /**
     * Connexion pour les utilisateurs (Gestionnaire, Comptable, Parent)
     */
    protected function loginUser($user, Request $request)
    {
        Log::info('Connexion utilisateur', [
            'email' => $user->email,
            'role' => $user->role,
            'statut' => $user->statut,
        ]);

        // Vérifier si le compte est actif
        if ($user->statut !== 'actif') {
            Auth::logout();
            return back()->with('error', 'Votre compte est désactivé. Veuillez contacter l\'administrateur.');
        }

        $request->session()->regenerate();
        $user->update(['last_login_at' => now()]);

        // Redirection selon le rôle
        switch ($user->role) {
            case 'gestionnaire_systeme':
                return redirect()->route('gestionnaire.dashboard')
                    ->with('success', 'Bienvenue ' . $user->name . ' !');
            
            case 'comptable':
                return redirect()->route('comptable.dashboard')
                    ->with('success', 'Bienvenue ' . $user->name . ' !');
            
            case 'parent':
                return redirect()->route('parent.dashboard')
                    ->with('success', 'Bienvenue ' . $user->name . ' !');
            
            default:
                return redirect('/');
        }
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        // Déconnexion pour les élèves (session)
        if (session()->has('eleve_id')) {
            session()->forget(['eleve_id', 'eleve_nom', 'eleve_email', 'eleve_role', 'is_eleve']);
            return redirect('/')->with('success', 'Déconnexion réussie.');
        }

        // Déconnexion pour les autres utilisateurs
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Déconnexion réussie.');
    }
}