<?php
// app/Http/Controllers/Parent/PaiementController.php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Frais;
use App\Models\Paiement;
use App\Models\ConfigurationMobileMoney;
use App\Models\SimulationPaiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaiementController extends Controller
{
    /**
     * Afficher le formulaire de paiement
     */
    public function showPaymentForm(Request $request)
    {
        $user = Auth::user();
        
        // Récupérer les élèves du parent (enfants)
        $enfants = Eleve::where('parent_id', $user->id)->with('classe')->get();
        
        // Récupérer les classes des enfants
        $classes = Classe::whereIn('id_classe', $enfants->pluck('classe_id'))->get();
        
        $operateurs = ConfigurationMobileMoney::where('statut', 'actif')->get();
        
        // Préparer les données pour le JavaScript
        $enfantsData = [];
        foreach ($enfants as $enfant) {
            $enfantsData[$enfant->classe_id][] = [
                'id' => $enfant->id_eleve,
                'nom' => $enfant->prenom . ' ' . $enfant->nom,
            ];
        }
        
        $fraisData = [];
        foreach ($enfants as $enfant) {
            $fraisData[$enfant->id_eleve] = Frais::where('classe_id', $enfant->classe_id)
                ->where('statut', 'actif')
                ->get()
                ->map(function($frais) {
                    $frais->est_depasse = $frais->date_echeance ? $frais->isDepasse() : false;
                    $frais->montant_final = $frais->est_depasse ? $frais->montant_avec_penalite : $frais->montant;
                    return $frais;
                });
        }
        
        return view('parent.paiement.form', compact('classes', 'operateurs', 'enfantsData', 'fraisData'));
    }

    /**
     * Traiter le paiement
     */
    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id_eleve',
            'frais_id' => 'required|exists:frais,id_frais',
            'operateur' => 'required|string',
            'numero_mobile' => 'required|string|regex:/^[0-9]{9,15}$/',
        ]);
        
        try {
            $eleve = Eleve::findOrFail($validated['eleve_id']);
            $frais = Frais::findOrFail($validated['frais_id']);
            
            // Vérifier que l'élève appartient au parent
            if ($eleve->parent_id !== Auth::id()) {
                return back()->with('error', 'Cet élève ne vous appartient pas.');
            }
            
            // Calculer le montant avec pénalité
            $montant = $frais->isDepasse() ? $frais->montant_avec_penalite : $frais->montant;
            
            // Créer le paiement
            $paiement = Paiement::create([
                'reference' => 'PAY-' . strtoupper(Str::random(13)),
                'montant' => $montant,
                'devise' => $frais->devise,
                'date_paiement' => now(),
                'statut' => 'valide',
                'operateur' => $validated['operateur'],
                'numero_mobile' => $validated['numero_mobile'],
                'eleve_id' => $eleve->id_eleve,
                'frais_id' => $frais->id_frais,
                'parent_id' => Auth::id(),
                'code_transaction' => 'TXN-' . strtoupper(Str::random(10)),
            ]);
            
            // Enregistrer la simulation
            SimulationPaiement::create([
                'paiement_id' => $paiement->id_paiement,
                'requete' => json_encode($validated),
                'reponse' => json_encode(['status' => 'success', 'message' => 'Paiement effectué']),
                'statut' => 'success',
                'temps_reponse_ms' => 1500,
            ]);
            
            return redirect()->route('parent.recu.show', $paiement->id_paiement)
                ->with('success', 'Paiement effectué avec succès !');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
        }
    }
    
    /**
     * Afficher le reçu
     */
    public function showReceipt($id)
    {
        $paiement = Paiement::with(['eleve.classe', 'parent', 'frais'])->findOrFail($id);
        
        if ($paiement->parent_id !== Auth::id()) {
            abort(403);
        }
        
        return view('parent.recu', compact('paiement'));
    }
    
    /**
     * Télécharger le reçu PDF
     */
    public function downloadReceipt($id)
    {
        $paiement = Paiement::with(['eleve.classe', 'parent', 'frais'])->findOrFail($id);
        
        if ($paiement->parent_id !== Auth::id()) {
            abort(403);
        }
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.recu', compact('paiement'));
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('recu_' . $paiement->reference . '.pdf');
    }
}