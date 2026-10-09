<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Paiement;
use App\Models\Eleve;
use Carbon\Carbon;

class HistoriqueController extends Controller
{
    public function index(Request $request)
    {
        $parent = Auth::user();
        
        // Récupérer les enfants du parent
        $enfants = Eleve::where('parent_id', $parent->id)->get();
        $enfantsIds = $enfants->pluck('id_eleve')->toArray();
        
        // Requête des paiements
        $query = Paiement::with(['eleve', 'frais'])
            ->whereIn('eleve_id', $enfantsIds);
        
        // Appliquer les filtres
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
        
        // Ordre chronologique
        $query->orderBy('created_at', 'desc');
        
        // Pagination
        $paiements = $query->paginate(15);
        
        // ✅ Appliquer le fuseau horaire de Lubumbashi à chaque paiement
        foreach ($paiements as $paiement) {
            $paiement->created_at_lubumbashi = Carbon::parse($paiement->created_at)
                ->setTimezone('Africa/Lubumbashi');
        }
        
        // ✅ Totaux séparés par devise (uniquement les paiements validés)
        $totalPayeUSD = Paiement::whereIn('eleve_id', $enfantsIds)
            ->where(function($q) {
                $q->where('statut', 'valide')
                  ->orWhere('statut', 'PAID')
                  ->orWhere('statut', 'VALIDÉ');
            })
            ->where('devise', 'USD')
            ->sum('montant');
        
        $totalPayeFC = Paiement::whereIn('eleve_id', $enfantsIds)
            ->where(function($q) {
                $q->where('statut', 'valide')
                  ->orWhere('statut', 'PAID')
                  ->orWhere('statut', 'VALIDÉ');
            })
            ->where(function($q) {
                $q->where('devise', 'CDF')
                  ->orWhere('devise', 'FC')
                  ->orWhere('devise', 'FRANC');
            })
            ->sum('montant');
        
        $nbPaiements = $query->count();
        
        return view('parent.historique', compact(
            'paiements', 
            'enfants', 
            'totalPayeUSD',
            'totalPayeFC', 
            'nbPaiements'
        ));
    }
}