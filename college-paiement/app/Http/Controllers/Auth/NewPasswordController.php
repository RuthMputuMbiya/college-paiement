<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request)
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'email.required' => 'L\'adresse email est requise',
            'password.required' => 'Le mot de passe est requis',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
        ]);

        // Vérifier si l'utilisateur est dans users
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $status = Password::broker('users')->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();

                    event(new PasswordReset($user));
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return redirect()->route('login')->with('status', __($status));
            }

            return back()->withErrors(['email' => [__($status)]]);
        }

        // Vérifier si l'utilisateur est dans eleves
        $eleve = Eleve::where('email', $request->email)->first();

        if ($eleve) {
            // Réinitialisation pour élève
            $eleve->update([
                'mot_de_passe' => Hash::make($request->password),
                'premiere_connexion' => false,
            ]);

            return redirect()->route('eleve.login')->with('success', 'Votre mot de passe a été réinitialisé avec succès.');
        }

        return back()->withErrors(['email' => 'Aucun compte trouvé avec cette adresse email.']);
    }
}