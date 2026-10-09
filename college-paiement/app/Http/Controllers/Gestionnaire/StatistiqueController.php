<?php
namespace App\Http\Controllers\Gestionnaire;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Eleve;
use App\Models\Paiement;

class StatistiqueController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_eleves' => Eleve::count(),
            'total_paiements' => Paiement::count(),
            'montant_total' => Paiement::where('statut', 'valide')->sum('montant'),
        ];
        $rolesLabels = ['Gestionnaires', 'Comptables', 'Parents'];
        $rolesData = [User::where('role', 'gestionnaire_systeme')->count(), User::where('role', 'comptable')->count(), User::where('role', 'parent')->count()];
        $evolutionMois = []; $evolutionMontants = [];
        for ($i = 5; $i >= 0; $i--) { $mois = now()->subMonths($i); $evolutionMois[] = $mois->translatedFormat('M Y'); $evolutionMontants[] = Paiement::whereYear('date_paiement', $mois->year)->whereMonth('date_paiement', $mois->month)->sum('montant'); }
        return view('gestionnaire.statistiques.index', compact('stats', 'rolesLabels', 'rolesData', 'evolutionMois', 'evolutionMontants'));
    }
}