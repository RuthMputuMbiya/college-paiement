<?php
// app/Http/Controllers/Comptable/StatistiqueController.php

namespace App\Http\Controllers\Comptable;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Classe;
use App\Models\Frais;
use App\Models\Paiement;
use App\Models\Litige;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    /**
     * Afficher les statistiques
     */
    public function index()
    {
        // Statistiques générales
        $stats = [
            'total_eleves' => Eleve::count(),
            'total_classes' => Classe::count(),
            'total_frais' => Frais::where('statut', 'actif')->count(),
            'total_paiements' => Paiement::count(),
            'total_paye' => Paiement::where('statut', 'valide')->sum('montant'),
            'total_litiges' => Litige::count(),
            'litiges_ouverts' => Litige::where('statut', 'ouvert')->count(),
        ];

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

        // Top classes par recettes
        $topClasses = Paiement::select('classes.nom_classe', DB::raw('SUM(paiements.montant) as total'))
            ->join('eleves', 'paiements.eleve_id', '=', 'eleves.id_eleve')
            ->join('classes', 'eleves.classe_id', '=', 'classes.id_classe')
            ->where('paiements.statut', 'valide')
            ->groupBy('classes.id_classe', 'classes.nom_classe')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return view('comptable.statistiques.index', compact('stats', 'evolutionMois', 'evolutionMontants', 'topClasses'));
    }

    /**
     * Récupérer les données pour les graphiques (AJAX)
     */
    public function getData(Request $request)
    {
        $period = $request->get('period', 12);
        
        $labels = [];
        $values = [];
        
        for ($i = $period - 1; $i >= 0; $i--) {
            $mois = now()->subMonths($i);
            $labels[] = $mois->translatedFormat('M Y');
            $values[] = Paiement::where('statut', 'valide')
                ->whereYear('date_paiement', $mois->year)
                ->whereMonth('date_paiement', $mois->month)
                ->sum('montant');
        }
        
        return response()->json([
            'labels' => $labels,
            'values' => $values
        ]);
    }
}