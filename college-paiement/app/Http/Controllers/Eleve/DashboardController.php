<?php
// app/Http/Controllers/Eleve/DashboardController.php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Paiement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord
     */
    public function index()
    {
        $eleve = Eleve::with(['classe.frais', 'paiements'])->find(session('eleve_id'));
        
        if (!$eleve) {
            return redirect()->route('eleve.login')->with('error', 'Session expirée.');
        }
        
        // Frais à payer
        $fraisAPayer = [];
        foreach ($eleve->classe->frais as $frais) {
            if ($frais->statut === 'actif') {
                $dejaPaye = $eleve->paiements
                    ->where('frais_id', $frais->id_frais)
                    ->where('statut', 'valide')
                    ->isNotEmpty();
                
                if (!$dejaPaye) {
                    $fraisAPayer[] = [
                        'frais' => $frais,
                        'montant' => $frais->isDepasse() ? $frais->montant_avec_penalite : $frais->montant,
                        'est_depasse' => $frais->isDepasse(),
                    ];
                }
            }
        }
        
        $paiements = $eleve->paiements()->with('frais')->orderBy('created_at', 'desc')->get();
        
        $totalPaye = $eleve->paiements()->where('statut', 'valide')->sum('montant');
        $totalRestant = collect($fraisAPayer)->sum('montant');
        $totalAttendu = $totalPaye + $totalRestant;
        $tauxPaiement = $totalAttendu > 0 ? round(($totalPaye / $totalAttendu) * 100, 2) : 100;
        
        $stats = [
            'total_paye' => $totalPaye,
            'total_restant' => $totalRestant,
            'nb_paiements' => $eleve->paiements()->where('statut', 'valide')->count(),
            'taux_paiement' => $tauxPaiement,
        ];
        
        return view('eleve.dashboard', compact('eleve', 'fraisAPayer', 'paiements', 'stats'));
    }
    
    /**
     * Afficher la liste des paiements
     */
    public function paiements(Request $request)
    {
        $eleve = Eleve::find(session('eleve_id'));
        
        if (!$eleve) {
            return redirect()->route('eleve.login')->with('error', 'Session expirée.');
        }
        
        $query = Paiement::where('eleve_id', $eleve->id_eleve)->with('frais');
        
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        
        if ($request->filled('operateur')) {
            $query->where('operateur', $request->operateur);
        }
        
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }
        
        $paiements = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $totalPaye = $eleve->paiements()->where('statut', 'valide')->sum('montant');
        $totalAttendu = $eleve->classe->frais->where('statut', 'actif')->sum('montant');
        $tauxPaiement = $totalAttendu > 0 ? round(($totalPaye / $totalAttendu) * 100, 2) : 100;
        
        $dernierPaiement = $eleve->paiements()->where('statut', 'valide')->latest()->first();
        
        $stats = [
            'total_paye' => $totalPaye,
            'nb_paiements' => $eleve->paiements()->where('statut', 'valide')->count(),
            'taux_paiement' => $tauxPaiement,
            'dernier_paiement' => $dernierPaiement ? $dernierPaiement->created_at->format('d/m/Y') : 'Aucun',
        ];
        
        return view('eleve.paiements', compact('paiements', 'stats'));
    }
}