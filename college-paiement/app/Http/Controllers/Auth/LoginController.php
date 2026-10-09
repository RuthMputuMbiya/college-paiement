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
        // Validation des champs
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
            'role'     => 'required|in:gestionnaire_systeme,comptable,parent,eleve',
        ], [
            'email.required'    => 'L\'adresse email est requise',
            'password.required' => 'Le mot de passe est requis',
            'role.required'     => 'Veuillez sélectionner votre rôle',
        ]);

        // Connexion pour les élèves (table eleves)
        if ($request->role === 'eleve') {
            return $this->loginEleve($request);
        }

        // Connexion pour les autres utilisateurs (table users)
        return $this->loginUser($request);
    }

    /**
     * Connexion pour les élèves (table eleves)
     */
    protected function loginEleve(Request $request)
    {
        // Rechercher l'élève par email
        $eleve = Eleve::where('email', $request->email)->first();

        // DEBUG: Journaliser la tentative (à supprimer après tests)
        Log::info('Tentative connexion élève', [
            'email' => $request->email,
            'eleve_trouve' => $eleve ? 'oui' : 'non',
            'statut' => $eleve ? $eleve->statut : null,
        ]);

        // Vérifier si l'élève existe
        if (!$eleve) {
            return back()->withErrors(['email' => 'Aucun compte trouvé avec cet email.'])->withInput();
        }

        // Vérifier le mot de passe
        if (!Hash::check($request->password, $eleve->mot_de_passe)) {
            return back()->withErrors(['email' => 'Mot de passe incorrect.'])->withInput();
        }

        // Vérifier le statut de l'élève
        if ($eleve->statut !== 'inscrit') {
            return back()->with('error', 'Votre compte élève est désactivé. Veuillez contacter l\'administration.');
        }

        // Stocker l'élève en session
        session([
            'eleve_id'    => $eleve->id_eleve,
            'eleve_nom'   => $eleve->prenom . ' ' . $eleve->nom,
            'eleve_email' => $eleve->email,
            'eleve_role'  => 'eleve',
            'is_eleve'    => true,
        ]);

        // Mettre à jour la dernière connexion
        $eleve->update(['last_login_at' => now()]);

        // Redirection pour première connexion (changement de mot de passe obligatoire)
        if ($eleve->premiere_connexion) {
            return redirect()->route('eleve.profile.edit-password')
                ->with('warning', 'Bienvenue ! Veuillez changer votre mot de passe avant de continuer.');
        }

        return redirect()->route('eleve.dashboard')
            ->with('success', 'Bienvenue ' . $eleve->prenom . ' !');
    }

    /**
     * Connexion pour les utilisateurs (table users)
     */
    protected function loginUser(Request $request)
    {
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            // Vérifier le rôle sélectionné
            if ($user->role !== $request->role) {
                Auth::logout();
                return back()->with('error', 'Rôle incorrect. Veuillez sélectionner le bon rôle.')
                    ->withInput();
            }

            // Vérifier si le compte est actif
            if ($user->statut !== 'actif') {
                Auth::logout();
                return back()->with('error', 'Votre compte est désactivé. Veuillez contacter l\'administrateur.');
            }

            // Régénérer la session pour sécurité
            $request->session()->regenerate();

            // Mettre à jour la dernière connexion
            $user->update(['last_login_at' => now()]);

            // Redirection selon le rôle
            if ($user->role === 'gestionnaire_systeme') {
                return redirect()->route('gestionnaire.dashboard')
                    ->with('success', 'Bienvenue ' . $user->name . ' !');
            }

            if ($user->role === 'comptable') {
                return redirect()->route('comptable.dashboard')
                    ->with('success', 'Bienvenue ' . $user->name . ' !');
            }

            if ($user->role === 'parent') {
                return redirect()->route('parent.dashboard')
                    ->with('success', 'Bienvenue ' . $user->name . ' !');
            }

            return redirect('/');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.'])->withInput();
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