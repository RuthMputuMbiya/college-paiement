<?php
namespace App\Http\Controllers\Gestionnaire;
use App\Http\Controllers\Controller;
use App\Models\Paiement;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Paiement::with('eleve')->orderBy('created_at', 'desc')->paginate(20);
        $stats = [
            'total' => Paiement::count(),
            'valides' => Paiement::where('statut', 'valide')->count(),
            'attente' => Paiement::where('statut', 'en_attente')->count(),
            'echoues' => Paiement::where('statut', 'echoue')->count(),
        ];
        return view('gestionnaire.payments.index', compact('payments', 'stats'));
    }
}