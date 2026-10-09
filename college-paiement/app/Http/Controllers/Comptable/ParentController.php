<?php

namespace App\Http\Controllers\Comptable;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Eleve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ParentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'parent')->with('eleves');
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('telephone', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        
        $parents = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $stats = [
            'actifs' => User::where('role', 'parent')->where('statut', 'actif')->count(),
            'total_enfants' => Eleve::count(),
            'total_paye' => \App\Models\Paiement::where('statut', 'valide')->sum('montant'),
        ];
        
        return view('comptable.parents.index', compact('parents', 'stats'));
    }

    public function create()
    {
        return view('comptable.parents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|string|max:20',
            'adresse' => 'nullable|string|max:500',
            'profession' => 'nullable|string|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        $parent = User::create([
            'identifiant_unique' => 'PAR-' . now()->format('Ymd') . '-' . Str::random(6),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'adresse' => $validated['adresse'] ?? null,
            'profession' => $validated['profession'] ?? null,
            'role' => 'parent',
            'statut' => 'actif',
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('comptable.parents.index')
            ->with('success', "Parent {$parent->name} créé avec succès.");
    }

    public function show($id)
    {
        $parent = User::with(['eleves.classe', 'paiements'])->findOrFail($id);
        $totalPaye = $parent->paiements()->where('statut', 'valide')->sum('montant');
        $nbPaiements = $parent->paiements()->where('statut', 'valide')->count();
        
        return view('comptable.parents.show', compact('parent', 'totalPaye', 'nbPaiements'));
    }

    public function edit($id)
    {
        $parent = User::findOrFail($id);
        return view('comptable.parents.edit', compact('parent'));
    }

    public function update(Request $request, $id)
    {
        $parent = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'adresse' => 'nullable|string|max:500',
            'profession' => 'nullable|string|max:255',
            'statut' => 'required|in:actif,inactif',
        ]);

        $parent->update($validated);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $parent->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('comptable.parents.index')
            ->with('success', "Parent {$parent->name} mis à jour.");
    }

    public function destroy($id)
    {
        $parent = User::findOrFail($id);
        
        // Détacher les élèves
        Eleve::where('parent_id', $parent->id)->update(['parent_id' => null]);
        
        $parent->delete();
        
        return redirect()->route('comptable.parents.index')
            ->with('success', 'Parent supprimé.');
    }
}