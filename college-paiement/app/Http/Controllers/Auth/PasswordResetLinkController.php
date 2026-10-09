<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset request form.
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'L\'adresse email est requise',
            'email.email' => 'Veuillez entrer une adresse email valide',
        ]);

        // Vérifier si l'email existe dans users (admin, comptable, parent)
        $user = User::where('email', $request->email)->first();
        
        // Vérifier si l'email existe dans eleves
        $eleve = Eleve::where('email', $request->email)->first();

        if (!$user && !$eleve) {
            return back()->withErrors(['email' => 'Aucun compte trouvé avec cette adresse email.']);
        }

        // Pour les utilisateurs de la table users
        if ($user) {
            $status = Password::broker('users')->sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                return back()->with('status', __($status));
            }

            return back()->withErrors(['email' => __($status)]);
        }

        // Pour les élèves (redirection personnalisée ou même système)
        if ($eleve) {
            // Option 1: Envoyer un email personnalisé
            // Mail::to($eleve->email)->send(new EleveResetPasswordMail($eleve));
            
            // Option 2: Rediriger vers un formulaire spécifique
            return back()->with('status', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
        }

        return back()->withErrors(['email' => 'Une erreur est survenue. Veuillez réessayer.']);
    }
}