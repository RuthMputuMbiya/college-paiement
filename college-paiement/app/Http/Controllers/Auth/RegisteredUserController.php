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
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validator($request->all())->validate();

        $user = $this->registerUser($request->all());

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('parent.dashboard'))->with('success', 'Bienvenue ! Votre compte parent a été créé avec succès.');
    }
    
    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'telephone'  => ['required', 'string', 'max:20'],
            'adresse'    => ['nullable', 'string', 'max:500'],
            'profession' => ['nullable', 'string', 'max:255'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
            'terms'      => ['required', 'accepted'],
        ], [
            'name.required' => 'Le nom complet est requis',
            'email.required' => 'L\'adresse email est requise',
            'email.unique' => 'Cet email est déjà utilisé',
            'telephone.required' => 'Le numéro de téléphone est requis',
            'password.required' => 'Le mot de passe est requis',
            'password.confirmed' => 'Les mots de passe ne correspondent pas',
            'terms.required' => 'Vous devez accepter les conditions générales',
            'terms.accepted' => 'Vous devez accepter les conditions générales',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function registerUser(array $data): User
    {
        return User::create([
            'identifiant_unique' => $this->generateIdentifiant(),
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
     * Generate a unique identifier for the user.
     */
    private function generateIdentifiant(): string
    {
        return 'PAR-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
    }
}