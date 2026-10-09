<?php
// app/Http/Controllers/Comptable/PaiementController.php

namespace App\Http\Controllers\Comptable;

use App\Http\Controllers\Controller;
use App\Models\Paiement;
use App\Models\Classe;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaiementController extends Controller
{
    public function index(Request $request)
    {
        $query = Paiement::with(['eleve.classe', 'parent', 'frais']);
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('reference', 'like', '%' . $request->search . '%')
                  ->orWhereHas('eleve', fn($q2) => $q2->where('nom', 'like', '%' . $request->search . '%'))
                  ->orWhereHas('parent', fn($q2) => $q2->where('name', 'like', '%' . $request->search . '%'));
            });
        }
        
        if ($request->filled('statut')) $query->where('statut', $request->statut);
        if ($request->filled('operateur')) $query->where('operateur', $request->operateur);
        if ($request->filled('classe_id')) $query->whereHas('eleve', fn($q) => $q->where('classe_id', $request->classe_id));
        if ($request->filled('date_debut')) $query->whereDate('date_paiement', '>=', $request->date_debut);
        if ($request->filled('date_fin')) $query->whereDate('date_paiement', '<=', $request->date_fin);
        
        $paiements = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Appliquer le fuseau horaire de Lubumbashi
        foreach ($paiements as $paiement) {
            $paiement->created_at_lubumbashi = Carbon::parse($paiement->created_at)
                ->setTimezone('Africa/Lubumbashi');
        }
        
        $classes = Classe::all();
        
        // Calcul des totaux par devise
        $totalUSD = Paiement::where('statut', 'valide')->where('devise', 'USD')->sum('montant');
        $totalFC = Paiement::where('statut', 'valide')
            ->where(function($q) {
                $q->where('devise', 'CDF')->orWhere('devise', 'FC');
            })
            ->sum('montant');
        
        $stats = [
            'total' => Paiement::count(),
            'valides' => Paiement::where('statut', 'valide')->count(),
            'en_attente' => Paiement::where('statut', 'en_attente')->count(),
            'echoues' => Paiement::where('statut', 'echoue')->count(),
            'montant_total_usd' => $totalUSD,
            'montant_total_fc' => $totalFC,
            'taux_succes' => Paiement::count() > 0 ? round((Paiement::where('statut', 'valide')->count() / Paiement::count()) * 100, 2) : 0,
        ];
        
        return view('comptable.paiements.index', compact('paiements', 'stats', 'classes'));
    }
    
    public function show($id)
    {
        $paiement = Paiement::with(['eleve.classe', 'parent', 'frais', 'simulation'])->findOrFail($id);
        
        // Appliquer le fuseau horaire
        $paiement->created_at_lubumbashi = Carbon::parse($paiement->created_at)
            ->setTimezone('Africa/Lubumbashi');
        
        return view('comptable.paiements.show', compact('paiement'));
    }
    
    public function validatePayment($id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->update(['statut' => 'valide']);
        return response()->json(['success' => true]);
    }
    
    /**
     * Télécharger le reçu au format PDF
     */
    public function downloadReceipt($id)
    {
        $paiement = Paiement::with(['eleve.classe', 'parent', 'frais'])
            ->findOrFail($id);
        
        // Vérifier que le paiement existe et est validé
        if ($paiement->statut != 'valide') {
            abort(403, 'Seuls les paiements validés peuvent générer un reçu.');
        }
        
        // Générer le PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.recu_comptable', compact('paiement'));
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('recu_' . $paiement->reference . '.pdf');
    }
}