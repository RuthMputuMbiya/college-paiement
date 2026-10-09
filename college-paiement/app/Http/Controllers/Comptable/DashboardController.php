<?php
// app/Http/Controllers/Comptable/DashboardController.php

namespace App\Http\Controllers\Comptable;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Frais;
use App\Models\Paiement;
use App\Models\Litige;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_eleves' => Eleve::count(),
            'total_classes' => Classe::count(),
            'total_paiements' => Paiement::count(),
            'paiements_valides' => Paiement::where('statut', 'valide')->count(),
            'montant_total' => Paiement::where('statut', 'valide')->sum('montant'),
            'litiges_ouverts' => Litige::where('statut', 'ouvert')->count(),
            'litiges_attente' => Litige::whereIn('statut', ['ouvert', 'en_cours'])->count(),
            'taux_recouvrement' => $this->calculerTauxRecouvrement(),
        ];

        // Répartition par opérateur
        $operateurs = Paiement::select('operateur', DB::raw('count(*) as total'))
            ->groupBy('operateur')
            ->get();
        
        $operateurLabels = $operateurs->pluck('operateur')->map(function($op) {
            return ucfirst($op);
        });
        $operateurData = $operateurs->pluck('total');

        // Évolution des paiements (6 derniers mois)
        $evolutionMois = [];
        $evolutionMontants = [];
        for ($i = 5; $i >= 0; $i--) {
            $mois = now()->subMonths($i);
            $evolutionMois[] = $mois->translatedFormat('M Y');
            $montant = Paiement::where('statut', 'valide')
                ->whereYear('date_paiement', $mois->year)
                ->whereMonth('date_paiement', $mois->month)
                ->sum('montant');
            $evolutionMontants[] = $montant;
        }

        // Derniers paiements
        $recentPayments = Paiement::with(['eleve.classe'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('comptable.dashboard', compact('stats', 'operateurLabels', 'operateurData', 'evolutionMois', 'evolutionMontants', 'recentPayments'));
    }

    private function calculerTauxRecouvrement()
    {
        $montantAttendu = Frais::where('statut', 'actif')->sum('montant') * Eleve::count();
        $montantCollecte = Paiement::where('statut', 'valide')->sum('montant');
        
        if ($montantAttendu == 0) return 0;
        return round(($montantCollecte / $montantAttendu) * 100, 2);
    }
}