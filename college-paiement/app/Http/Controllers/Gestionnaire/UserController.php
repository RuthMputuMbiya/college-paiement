<?php
// app/Http/Controllers/Gestionnaire/UserController.php

namespace App\Http\Controllers\Gestionnaire;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Afficher la liste des utilisateurs
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('gestionnaire.users.index', compact('users'));
    }

    /**
     * Afficher le formulaire de création
     */
    public function create()
    {
        return view('gestionnaire.users.create');
    }

    /**
     * Enregistrer un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|string|max:20',
            'adresse' => 'nullable|string|max:500',
            'profession' => 'nullable|string|max:255',
            'role' => 'required|in:gestionnaire_systeme,comptable,parent',
            'password' => 'required|min:6|confirmed',
        ]);

        $validated['identifiant_unique'] = 'USR-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        $validated['statut'] = 'actif';
        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now();

        User::create($validated);

        return redirect()->route('gestionnaire.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Afficher les détails d'un utilisateur
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('gestionnaire.users.show', compact('user'));
    }

    /**
     * Afficher le formulaire d'édition
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('gestionnaire.users.edit', compact('user'));
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'nullable|string|max:500',
            'profession' => 'nullable|string|max:255',
            'role' => 'required|in:gestionnaire_systeme,comptable,parent',
            'statut' => 'required|in:actif,inactif',
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('gestionnaire.users.index')
            ->with('success', 'Utilisateur mis à jour.');
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        
        $user->delete();
        
        return redirect()->route('gestionnaire.users.index')
            ->with('success', 'Utilisateur supprimé.');
    }
}