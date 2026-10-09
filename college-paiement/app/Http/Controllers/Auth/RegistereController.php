<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Afficher le formulaire d'inscription.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Traiter la demande d'inscription.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation des données
        $this->validator($request->all())->validate();

        // Création de l'utilisateur parent
        $user = $this->createParentUser($request->all());

        // Déclencher l'événement d'enregistrement
        event(new Registered($user));

        // Connecter automatiquement l'utilisateur
        Auth::login($user);

        // Rediriger vers le tableau de bord parent
        return redirect()->route('parent.dashboard')
            ->with('success', 'Bienvenue ! Votre compte parent a été créé avec succès.');
    }
    
    /**
     * Obtenir le validateur pour la demande d'inscription.
     */
    protected function validator(array $data): \Illuminate\Validation\Validator
    {
        return Validator::make($data, [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'telephone'  => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'adresse'    => ['nullable', 'string', 'max:500'],
            'profession' => ['nullable', 'string', 'max:255'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
            'terms'      => ['required', 'accepted'],
        ], [
            // Messages d'erreur personnalisés en français
            'name.required' => 'Le nom complet est requis',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères',
            'email.required' => 'L\'adresse email est requise',
            'email.email' => 'Veuillez entrer une adresse email valide',
            'email.lowercase' => 'L\'adresse email doit être en minuscules',
            'email.unique' => 'Cet email est déjà utilisé par un autre compte',
            'telephone.required' => 'Le numéro de téléphone est requis',
            'telephone.regex' => 'Format de téléphone invalide. Exemple: +243 XXX XXX XXX',
            'password.required' => 'Le mot de passe est requis',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'terms.required' => 'Vous devez accepter les conditions générales',
            'terms.accepted' => 'Vous devez accepter les conditions générales pour continuer',
        ]);
    }

    /**
     * Créer un nouvel utilisateur parent après validation.
     */
    protected function createParentUser(array $data): User
    {
        return User::create([
            'identifiant_unique' => $this->generateUniqueIdentifiant(),
            'name'               => $data['name'],
            'email'              => $data['email'],
            'telephone'          => $data['telephone'] ?? null,
            'adresse'            => $data['adresse'] ?? null,
            'profession'         => $data['profession'] ?? null,
            'role'               => 'parent',
            'statut'             => 'actif',
            'password'           => Hash::make($data['password']),
            'email_verified_at'  => now(),
        ]);
    }
    
    /**
     * Générer un identifiant unique pour l'utilisateur parent.
     * Format: PAR-20250101-ABC123
     */
    private function generateUniqueIdentifiant(): string
    {
        $prefix = 'PAR';
        $date = now()->format('Ymd');
        $random = strtoupper(Str::random(6));
        
        return "{$prefix}-{$date}-{$random}";
    }
}