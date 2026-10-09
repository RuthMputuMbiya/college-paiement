<?php

namespace App\Http\Controllers\Eleve;

use App\Http\Controllers\Controller;
use App\Models\Eleve;
use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Afficher la liste des paiements de l'élève
     */
    public function index(Request $request)
    {
        $eleve = Eleve::find(session('eleve_id'));
        
        if (!$eleve) {
            return redirect()->route('eleve.login')->with('error', 'Session expirée.');
        }
        
        $query = Paiement::where('eleve_id', $eleve->id_eleve)->with('frais');
        
        // Filtres
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
        
        // Statistiques
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
    
    /**
     * Afficher les détails d'un paiement
     */
    public function show($id)
    {
        $eleve = Eleve::find(session('eleve_id'));
        
        if (!$eleve) {
            return redirect()->route('eleve.login')->with('error', 'Session expirée.');
        }
        
        $paiement = Paiement::with(['frais', 'eleve.classe'])
            ->where('eleve_id', $eleve->id_eleve)
            ->findOrFail($id);
        
        return view('eleve.paiements.show', compact('paiement'));
    }
    
    /**
     * Télécharger le reçu PDF
     */
    public function downloadReceipt($id)
    {
        $eleve = Eleve::find(session('eleve_id'));
        
        if (!$eleve) {
            return redirect()->route('eleve.login')->with('error', 'Session expirée.');
        }
        
        $paiement = Paiement::with(['frais', 'eleve.classe'])
            ->where('eleve_id', $eleve->id_eleve)
            ->findOrFail($id);
        
        // Vérifier que le paiement appartient bien à l'élève
        if ($paiement->eleve_id != $eleve->id_eleve) {
            abort(403, 'Accès non autorisé.');
        }
        
        // Générer le PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.recu', compact('paiement'));
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('recu_' . $paiement->reference . '.pdf');
    }
    
    /**
     * Imprimer l'historique des paiements
     */
    public function print()
    {
        $eleve = Eleve::find(session('eleve_id'));
        
        if (!$eleve) {
            return redirect()->route('eleve.login')->with('error', 'Session expirée.');
        }
        
        $paiements = Paiement::where('eleve_id', $eleve->id_eleve)
            ->with('frais')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalPaye = $paiements->where('statut', 'valide')->sum('montant');
        
        return view('eleve.paiements.print', compact('paiements', 'eleve', 'totalPaye'));
    }
}