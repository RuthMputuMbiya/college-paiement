<?php
namespace App\Http\Controllers\Gestionnaire;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Eleve;
use App\Models\Paiement;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_eleves' => Eleve::count(),
            'total_paiements' => Paiement::count(),
            'montant_total' => Paiement::where('statut', 'valide')->sum('montant'),
        ];
        return view('gestionnaire.dashboard.index', compact('stats'));
    }
}