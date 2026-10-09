<?php
// app/Http/Controllers/Parent/DashboardController.php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $enfants = Eleve::where('parent_id', $user->id)->with('classe.frais')->get();
        
        // Calcul des statistiques par enfant
        foreach ($enfants as $enfant) {
            $totalPaye = $enfant->paiements()->where('statut', 'valide')->sum('montant');
            
            // Calcul du total attendu
            $totalAttendu = $enfant->classe->frais->where('statut', 'actif')->sum('montant');
            $totalRestant = max(0, $totalAttendu - $totalPaye);
            $tauxPaiement = $totalAttendu > 0 ? round(($totalPaye / $totalAttendu) * 100, 2) : 100;
            
            $enfant->total_paye = $totalPaye;
            $enfant->total_restant = $totalRestant;
            $enfant->taux_paiement = $tauxPaiement;
        }
        
        // Statistiques globales
        $totalPayeGlobal = $enfants->sum('total_paye');
        $totalRestantGlobal = $enfants->sum('total_restant');
        $totalAttenduGlobal = $totalPayeGlobal + $totalRestantGlobal;
        $tauxGlobal = $totalAttenduGlobal > 0 ? round(($totalPayeGlobal / $totalAttenduGlobal) * 100, 2) : 100;
        
        $stats = [
            'total_enfants' => $enfants->count(),
            'total_paye' => $totalPayeGlobal,
            'total_restant' => $totalRestantGlobal,
            'paiements_effectues' => Paiement::where('parent_id', $user->id)->where('statut', 'valide')->count(),
            'taux_global' => $tauxGlobal,
        ];
        
        // Derniers paiements
        $recentPayments = Paiement::where('parent_id', $user->id)
            ->with(['eleve', 'frais'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('parent.dashboard', compact('enfants', 'stats', 'recentPayments'));
    }
    
    public function enfants()
    {
        $user = Auth::user();
        $enfants = Eleve::where('parent_id', $user->id)->with('classe.frais')->get();  // CORRIGÉ: 'clause' → 'classe'
        
        foreach ($enfants as $enfant) {
            $totalPaye = $enfant->paiements()->where('statut', 'valide')->sum('montant');
            $totalAttendu = $enfant->classe->frais->where('statut', 'actif')->sum('montant');
            $totalRestant = max(0, $totalAttendu - $totalPaye);
            $tauxPaiement = $totalAttendu > 0 ? round(($totalPaye / $totalAttendu) * 100, 2) : 100;
            
            $enfant->total_paye = $totalPaye;
            $enfant->total_restant = $totalRestant;
            $enfant->taux_paiement = $tauxPaiement;
        }
        
        return view('parent.enfants', compact('enfants'));
    }
    
    public function historique(Request $request)
    {
        $user = Auth::user();
        $query = Paiement::where('parent_id', $user->id)->with(['eleve', 'frais']);
        
        if ($request->filled('eleve_id')) {
            $query->where('eleve_id', $request->eleve_id);
        }
        
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }
        
        $paiements = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $totalPaye = $query->where('statut', 'valide')->sum('montant');
        $nbPaiements = $query->where('statut', 'valide')->count();
        
        $enfants = Eleve::where('parent_id', $user->id)->get();
        
        return view('parent.historique', compact('paiements', 'totalPaye', 'nbPaiements', 'enfants'));
    }
}