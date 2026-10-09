<?php
// app/Http/Controllers/Comptable/EleveController.php

namespace App\Http\Controllers\Comptable;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EleveController extends Controller
{
    /**
     * Afficher la liste des élèves
     */
    public function index(Request $request)
    {
        $query = Eleve::with(['classe', 'parent']);
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nom', 'like', '%' . $request->search . '%')
                  ->orWhere('prenom', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }
        
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        
        $eleves = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $classes = Classe::all();
        $stats = [
            'inscrits' => Eleve::where('statut', 'inscrit')->count(),
            'exclus' => Eleve::where('statut', 'exclu')->count(),
            'transferes' => Eleve::where('statut', 'transfere')->count(),
            'total_classes' => Classe::count(),
            'total_parents' => User::where('role', 'parent')->count(),
        ];
        
        return view('comptable.eleves.index', compact('eleves', 'classes', 'stats'));
    }

    /**
     * Afficher le formulaire de création d'élève
     */
    public function create()
    {
        $classes = Classe::all();
        $parents = User::where('role', 'parent')->orderBy('name')->get();
        return view('comptable.eleves.create', compact('classes', 'parents'));
    }

    /**
     * Enregistrer un nouvel élève
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'email' => 'required|email|unique:eleves',
            'mot_de_passe' => 'nullable|min:6',
            'date_naissance' => 'required|date',
            'sexe' => 'required|in:M,F',
            'classe_id' => 'required|exists:classes,id_classe',
            'parent_id' => 'nullable|exists:users,id',
            'nom_parent' => 'nullable|string|max:100',
            'email_parent' => 'nullable|email',
            'telephone_parent' => 'nullable|string|max:20',
        ], [
            'nom.required' => 'Le nom de l\'élève est requis',
            'prenom.required' => 'Le prénom de l\'élève est requis',
            'email.required' => 'L\'email de l\'élève est requis',
            'email.unique' => 'Cet email est déjà utilisé par un autre élève',
            'classe_id.required' => 'Veuillez sélectionner une classe',
        ]);

        // Vérifier la capacité de la classe
        $classe = Classe::find($validated['classe_id']);
        if ($classe->effectif >= $classe->capacite) {
            return back()->with('error', 'Cette classe a atteint sa capacité maximale (' . $classe->capacite . ' élèves).')
                         ->withInput();
        }

        // Gérer le compte parent
        $parent = null;
        
        if ($request->filled('parent_id')) {
            // Utiliser un parent existant
            $parent = User::find($request->parent_id);
        } elseif ($request->filled('email_parent')) {
            // Créer un nouveau compte parent
            $parent = User::firstOrCreate(
                ['email' => $validated['email_parent']],
                [
                    'identifiant_unique' => $this->generateParentIdentifiant(),
                    'name' => $validated['nom_parent'],
                    'telephone' => $validated['telephone_parent'],
                    'role' => 'parent',
                    'statut' => 'actif',
                    'password' => Hash::make(Str::random(10)),
                    'email_verified_at' => now(),
                ]
            );
        }

        // Vérifier qu'un parent a été trouvé ou créé
        if (!$parent) {
            return back()->with('error', 'Veuillez sélectionner un parent existant ou saisir les informations du parent.')
                         ->withInput();
        }

        // ⚠️ IMPORTANT: Mot de passe en clair (le mutator va le hasher automatiquement)
        $plainPassword = $request->filled('mot_de_passe') ? $request->mot_de_passe : 'password';

        // Créer l'élève - PAS DE HASH ICI, le mutator s'en charge
        $eleve = Eleve::create([
            'email' => $validated['email'],
            'mot_de_passe' => $plainPassword,  // ← En clair, le mutator va le hasher
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'date_naissance' => $validated['date_naissance'],
            'sexe' => $validated['sexe'],
            'telephone_parent' => $parent->telephone,
            'nom_parent' => $parent->name,
            'email_parent' => $parent->email,
            'classe_id' => $validated['classe_id'],
            'parent_id' => $parent->id,
            'statut' => 'inscrit',
            'premiere_connexion' => true,
        ]);

        // Incrémenter l'effectif de la classe
        $classe->increment('effectif');

        return redirect()->route('comptable.eleves.index')
            ->with('success', "✅ Élève {$eleve->prenom} {$eleve->nom} inscrit avec succès !\n📧 Email: {$eleve->email}\n🔑 Mot de passe: password");
    }

    /**
     * Afficher les détails d'un élève
     */
    public function show($id)
    {
        $eleve = Eleve::with(['classe', 'parent', 'paiements' => function($q) {
            $q->orderBy('created_at', 'desc')->limit(10);
        }])->findOrFail($id);
        
        $stats = [
            'total_paye' => $eleve->paiements()->where('statut', 'valide')->sum('montant'),
            'nb_paiements' => $eleve->paiements()->where('statut', 'valide')->count(),
        ];
        
        return view('comptable.eleves.show', compact('eleve', 'stats'));
    }

    /**
     * Afficher le formulaire d'édition d'un élève
     */
    public function edit($id)
    {
        $eleve = Eleve::findOrFail($id);
        $classes = Classe::all();
        $parents = User::where('role', 'parent')->orderBy('name')->get();
        return view('comptable.eleves.edit', compact('eleve', 'classes', 'parents'));
    }

    /**
     * Mettre à jour un élève
     */
    public function update(Request $request, $id)
    {
        $eleve = Eleve::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:50',
            'prenom' => 'required|string|max:50',
            'email' => 'required|email|unique:eleves,email,' . $id . ',id_eleve',
            'date_naissance' => 'required|date',
            'sexe' => 'required|in:M,F',
            'classe_id' => 'required|exists:classes,id_classe',
            'statut' => 'required|in:inscrit,exclu,transfere',
            'parent_id' => 'nullable|exists:users,id',
            'nom_parent' => 'nullable|string|max:100',
            'email_parent' => 'nullable|email',
            'telephone_parent' => 'nullable|string|max:20',
        ]);

        // Gérer le changement de classe
        if ($eleve->classe_id != $validated['classe_id']) {
            // Vérifier la capacité de la nouvelle classe
            $nouvelleClasse = Classe::find($validated['classe_id']);
            if ($nouvelleClasse->effectif >= $nouvelleClasse->capacite) {
                return back()->with('error', 'La nouvelle classe a atteint sa capacité maximale.');
            }
            
            // Décrémenter l'ancienne classe
            $ancienneClasse = Classe::find($eleve->classe_id);
            $ancienneClasse->decrement('effectif');
            
            // Incrémenter la nouvelle classe
            $nouvelleClasse->increment('effectif');
        }

        // Gérer la mise à jour du parent
        if ($request->filled('parent_id') && $eleve->parent_id != $request->parent_id) {
            $newParent = User::find($request->parent_id);
            if ($newParent) {
                $eleve->parent_id = $newParent->id;
                $eleve->nom_parent = $newParent->name;
                $eleve->email_parent = $newParent->email;
                $eleve->telephone_parent = $newParent->telephone;
            }
        } elseif ($request->filled('email_parent') && !$request->filled('parent_id')) {
            // Créer un nouveau parent
            $newParent = User::firstOrCreate(
                ['email' => $validated['email_parent']],
                [
                    'identifiant_unique' => $this->generateParentIdentifiant(),
                    'name' => $validated['nom_parent'],
                    'telephone' => $validated['telephone_parent'],
                    'role' => 'parent',
                    'statut' => 'actif',
                    'password' => Hash::make(Str::random(10)),
                    'email_verified_at' => now(),
                ]
            );
            $eleve->parent_id = $newParent->id;
            $eleve->nom_parent = $newParent->name;
            $eleve->email_parent = $newParent->email;
            $eleve->telephone_parent = $newParent->telephone;
        }

        // Mettre à jour le mot de passe si fourni (en clair)
        if ($request->filled('mot_de_passe')) {
            $request->validate([
                'mot_de_passe' => 'min:6|confirmed',
            ]);
            $eleve->mot_de_passe = $request->mot_de_passe;  // ← En clair, le mutator va le hasher
            $eleve->premiere_connexion = false;
        }

        $eleve->update($validated);

        return redirect()->route('comptable.eleves.index')
            ->with('success', "Élève {$eleve->prenom} {$eleve->nom} mis à jour.");
    }

    /**
     * Supprimer un élève
     */
    public function destroy($id)
    {
        $eleve = Eleve::findOrFail($id);
        $nom = $eleve->prenom . ' ' . $eleve->nom;
        
        // Vérifier si l'élève a des paiements
        if ($eleve->paiements()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer un élève qui a des paiements.');
        }
        
        // Décrémenter l'effectif de la classe
        $classe = Classe::find($eleve->classe_id);
        $classe->decrement('effectif');
        
        $eleve->delete();
        
        return redirect()->route('comptable.eleves.index')
            ->with('success', "Élève {$nom} supprimé.");
    }

    /**
     * Générer un identifiant unique pour le parent
     */
    private function generateParentIdentifiant(): string
    {
        return 'PAR-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
    }

    /**
     * Exporter la liste des élèves en Excel
     */
    public function export()
    {
        return redirect()->back()->with('info', 'Export Excel en cours de développement');
    }

    /**
     * Imprimer la liste des élèves
     */
    public function print()
    {
        $eleves = Eleve::with('classe')->orderBy('created_at', 'desc')->get();
        return view('comptable.eleves.print', compact('eleves'));
    }

    /**
     * Statistiques des élèves
     */
    public function statistiques()
    {
        $stats = [
            'total' => Eleve::count(),
            'par_classe' => Eleve::select('classe_id', DB::raw('count(*) as total'))
                ->groupBy('classe_id')
                ->with('classe')
                ->get(),
            'par_sexe' => [
                'M' => Eleve::where('sexe', 'M')->count(),
                'F' => Eleve::where('sexe', 'F')->count(),
            ],
            'par_statut' => [
                'inscrit' => Eleve::where('statut', 'inscrit')->count(),
                'exclu' => Eleve::where('statut', 'exclu')->count(),
                'transfere' => Eleve::where('statut', 'transfere')->count(),
            ],
        ];
        
        return view('comptable.eleves.statistiques', compact('stats'));
    }
}