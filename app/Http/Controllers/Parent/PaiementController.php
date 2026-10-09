<?php

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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaiementController extends Controller
{
    /**
     * Configuration FlexPay centralisée
     */
    private function getFlexPayConfig()
    {
        return [
            'token' => env('FLEXPAY_TOKEN', "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJcL2xvZ2luIiwicm9sZXMiOlsiTUVSQ0hBTlQiXSwiZXhwIjoxODMyMjI5MDI0LCJzdWIiOiIwN2I5MTZiZTU1ZWU4NTZmNTFmYjUyNWE2YWEzNmIyZCJ9.k4zRHKgCRY8WeLLdLjWWf5e8MoZrcPnT1Zb8OFXTexA"),
            'merchant' => env('FLEXPAY_MERCHANT', "QUINMBUKA"),
            'currency' => env('FLEXPAY_CURRENCY', "USD"),
            'payment_url' => env('FLEXPAY_PAYMENT_URL', 'https://backend.flexpay.cd/api/rest/v1/paymentService'),
            'check_url' => env('FLEXPAY_CHECK_URL', 'https://backend.flexpay.cd/api/rest/v1/check'),
        ];
    }

    /**
     * Convertir les devises pour FlexPay
     */
    private function convertCurrencyForFlexPay($currency)
    {
        return match(strtoupper($currency)) {
            'CDF', 'FC', 'FRANC', 'CONGOLESE FRANC' => 'CDF',
            'USD', 'DOLLAR', 'US', 'US DOLLAR' => 'USD',
            default => 'USD'
        };
    }

    /**
     * Formater le montant selon la devise (pour l'envoi à FlexPay)
     */
    private function formatAmount($amount, $currency)
    {
        $amount = (float)$amount;
        
        return match(strtoupper($currency)) {
            'CDF', 'FC' => number_format($amount, 0, '.', ''),
            'USD' => number_format($amount, 2, '.', ''),
            default => number_format($amount, 2, '.', '')
        };
    }

    /**
     * Formater l'affichage du montant avec devise (POUR L'AFFICHAGE DANS LA VUE)
     */
    private function formatMontantAffichage($montant, $devise)
    {
        $montant = (float)$montant;
        
        if ($devise == 'USD') {
            return number_format($montant, 2, ',', ' ') . ' USD';
        } else {
            return number_format($montant, 0, ',', ' ') . ' FC';
        }
    }

    /**
     * Afficher le formulaire de paiement
     */
    public function showPaymentForm(Request $request)
    {
        $user = Auth::user();

        // Récupérer les élèves du parent
        $enfants = Eleve::where('parent_id', $user->id)
            ->with('classe')
            ->get();

        // Vérifier si le parent a des enfants
        if ($enfants->isEmpty()) {
            return back()->with('error', 'Vous n\'avez aucun enfant inscrit.');
        }

        // Classes (uniques)
        $classes = Classe::whereIn(
            'id_classe',
            $enfants->pluck('classe_id')->unique()
        )->get();

        // Opérateurs Mobile Money actifs
        $operateurs = ConfigurationMobileMoney::where('statut', 'actif')->get();

        // Données enfants par classe
        $enfantsData = [];
        foreach ($enfants as $enfant) {
            if (!isset($enfantsData[$enfant->classe_id])) {
                $enfantsData[$enfant->classe_id] = [];
            }
            $enfantsData[$enfant->classe_id][] = [
                'id' => $enfant->id_eleve,
                'nom' => $enfant->prenom . ' ' . $enfant->nom,
            ];
        }

        // Données frais par élève avec support multi-devises
        $fraisData = [];
        foreach ($enfants as $enfant) {
            $fraisList = Frais::where('classe_id', $enfant->classe_id)
                ->where('statut', 'actif')
                ->get();
            
            if ($fraisList->isNotEmpty()) {
                $fraisArray = [];
                foreach ($fraisList as $frais) {
                    $estDepasse = false;
                    $penalite = 0;
                    
                    if ($frais->date_echeance) {
                        $dateEcheance = Carbon::parse($frais->date_echeance);
                        $estDepasse = $dateEcheance->isPast();
                        $penalite = (float)($frais->penaltie ?? 0);
                    }
                    
                    $montantBase = (float)$frais->montant;
                    $montantFinal = $estDepasse && $penalite > 0 
                        ? $montantBase + $penalite 
                        : $montantBase;
                    
                    // Récupérer la devise - par défaut FC
                    $devise = strtoupper($frais->devise ?? 'FC');
                    
                    $fraisArray[] = [
                        'id_frais' => $frais->id_frais,
                        'libelle' => $frais->libelle ?? $frais->libre ?? 'Frais scolaire',
                        'description' => $frais->description ?? '',
                        'montant' => $montantBase,
                        'devise' => $devise,
                        'devise_symbole' => $devise === 'USD' ? '$' : 'FC',
                        'penalite' => $penalite,
                        'est_depasse' => $estDepasse,
                        'montant_final' => $montantFinal,
                        'montant_final_formate' => $this->formatMontantAffichage($montantFinal, $devise),
                    ];
                }
                $fraisData[$enfant->id_eleve] = $fraisArray;
            } else {
                $fraisData[$enfant->id_eleve] = [];
            }
        }

        return view('parent.paiement.form', compact(
            'classes',
            'operateurs',
            'enfantsData',
            'fraisData'
        ));
    }

    /**
     * Traiter le paiement Mobile Money via FlexPay (Support CDF + USD)
     */
    public function processPayment(Request $request)
    {
        // ✅ AJOUT DE LA VALIDATION DE LA DEVISE
        $validated = $request->validate([
            'eleve_id' => 'required|exists:eleves,id_eleve',
            'frais_id' => 'required|exists:frais,id_frais',
            'operateur' => 'required|string',
            'numero_mobile' => 'required|string|min:9|max:12',
            'montant' => 'required|numeric|min:1',
            'devise' => 'required|in:FC,USD',  // ✅ NOUVEAU CHAMP
        ]);

        try {
            $eleve = Eleve::findOrFail($validated['eleve_id']);
            $frais = Frais::findOrFail($validated['frais_id']);

            // Vérifier que l'élève appartient bien au parent connecté
            if ($eleve->parent_id != Auth::id()) {
                return back()->with('error', 'Cet élève ne vous appartient pas.');
            }

            // Vérifier que le frais correspond à la classe de l'élève
            if ($frais->classe_id != $eleve->classe_id) {
                return back()->with('error', 'Ce frais ne correspond pas à la classe de l\'élève.');
            }

            // Calculer le montant avec pénalité si nécessaire
            $estDepasse = false;
            $penalite = 0;
            if ($frais->date_echeance) {
                $dateEcheance = Carbon::parse($frais->date_echeance);
                $estDepasse = $dateEcheance->isPast();
                $penalite = (float)($frais->penaltie ?? 0);
            }
            
            $montant = $estDepasse && $penalite > 0 
                ? (float)$frais->montant + $penalite 
                : (float)$frais->montant;
            
            // Vérifier que le montant correspond
            if ((float)$montant != (float)$validated['montant']) {
                return back()->with('error', 'Le montant ne correspond pas.');
            }

            // ✅ UTILISER LA DEVISE ENVOYÉE PAR LE FORMULAIRE
            $devise = $validated['devise'];  // 'FC' ou 'USD'
            
            // Convertir la devise pour FlexPay (CDF ou USD)
            $flexpayCurrency = ($devise == 'USD') ? 'USD' : 'CDF';
            
            // Formater le montant selon la devise pour l'envoi
            if ($devise == 'USD') {
                $formattedAmount = number_format($montant, 2, '.', '');
            } else {
                $formattedAmount = number_format($montant, 0, '.', '');
            }

            // Générer une référence unique
            $reference = 'PAY-' . strtoupper(Str::random(10)) . '-' . date('YmdHis');

            // Configuration FlexPay
            $config = $this->getFlexPayConfig();
            
            // Nettoyer le numéro de téléphone
            $phoneNumber = preg_replace('/[^0-9]/', '', $validated['numero_mobile']);
            if (strlen($phoneNumber) == 9) {
                $phoneNumber = '243' . $phoneNumber;
            }

            // Payload avec support multi-devises
            $payload = [
                "merchant" => $config['merchant'],
                "type" => 1,
                "reference" => $reference,
                "phone" => $phoneNumber,
                "amount" => $formattedAmount,
                "currency" => $flexpayCurrency,
                "callbackUrl" => route('flexpay.callback'),
            ];

            $payload["description"] = "Paiement des frais scolaires - " . ($frais->libelle ?? 'Frais scolaire') . " (" . $flexpayCurrency . ")";

            \Log::info('FlexPay Request', [
                'url' => $config['payment_url'],
                'payload' => $payload,
                'devise' => $devise,
                'flexpay_currency' => $flexpayCurrency
            ]);

            // Requête vers FlexPay
            $response = Http::withHeaders([
                'Authorization' => $config['token'],
                'Accept' => 'application/json',
            ])->withoutVerifying()
              ->timeout(30)
              ->post($config['payment_url'], $payload);

            $responseData = $response->json();
            
            \Log::info('FlexPay Response', [
                'status' => $response->status(),
                'data' => $responseData
            ]);

            if (!$response->successful()) {
                \Log::error('FlexPay API error', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return back()->with('error', 'Erreur de communication avec FlexPay.');
            }

            if (intval($responseData['code'] ?? -1) != 0) {
                $errorMsg = $responseData['message'] ?? 'Paiement refusé par FlexPay';
                return back()->with('error', $errorMsg);
            }

            // ✅ CRÉATION DU PAIEMENT AVEC LA BONNE DEVISE
            $paiement = Paiement::create([
                'reference' => $reference,
                'montant' => $montant,
                'devise' => $devise,  // 'FC' ou 'USD'
                'date_paiement' => now(),
                'statut' => 'en_attente',
                'operateur' => $validated['operateur'],
                'numero_mobile' => $phoneNumber,
                'eleve_id' => $eleve->id_eleve,
                'frais_id' => $frais->id_frais,
                'parent_id' => Auth::id(),
                'code_transaction' => $responseData['orderNumber'] ?? null,
            ]);

            SimulationPaiement::create([
                'paiement_id' => $paiement->id_paiement,
                'requete' => json_encode($payload),
                'reponse' => json_encode($responseData),
                'statut' => 'success',
                'temps_reponse_ms' => $response->handlerStats()['total_time'] ?? 1500,
            ]);

            return redirect()
                ->route('parent.paiement.status', ['id' => $paiement->id_paiement])
                ->with('success', 'Demande de paiement de ' . $this->formatMontantAffichage($montant, $devise) . ' envoyée avec succès.');

        } catch (\Exception $e) {
            \Log::error('Paiement error', [
                'message' => $e->getMessage(), 
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Une erreur est survenue : ' . $e->getMessage())->withInput();
        }
    }

    /**
     * PAGE DE STATUT
     */
    public function paymentStatus($id)
    {
        $paiement = Paiement::with(['eleve.classe', 'frais'])->findOrFail($id);
        
        if ($paiement->parent_id !== Auth::id()) {
            abort(403);
        }
        
        return view('parent.paiement.status', compact('paiement'));
    }

    /**
     * API STATUS pour auto-refresh (AJAX)
     */
    public function paymentStatusApi($id)
    {
        $paiement = Paiement::findOrFail($id);
        
        if ($paiement->parent_id !== Auth::id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }
        
        return response()->json([
            'status' => $paiement->statut,
            'transaction_id' => $paiement->code_transaction,
            'paid_at' => $paiement->date_validation ? \Carbon\Carbon::parse($paiement->date_validation)->setTimezone('Africa/Lubumbashi')->format('d/m/Y H:i') : null,
            'reference' => $paiement->reference,
            'montant' => $paiement->montant,
            'montant_formate' => $this->formatMontantAffichage($paiement->montant, $paiement->devise),
            'devise' => $paiement->devise,
            'devise_symbole' => $paiement->devise === 'USD' ? '$' : 'FC',
        ]);
    }

    /**
     * VÉRIFICATION MANUELLE FLEXPAY (GET avec ID dans URL)
     */
    public function checkFlexPayPayment($id)
    {
        $paiement = Paiement::findOrFail($id);
        
        if ($paiement->parent_id !== Auth::id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }
        
        $config = $this->getFlexPayConfig();
        
        $url = $config['check_url'] . '/' . $paiement->reference;
        
        try {
            $response = Http::withHeaders([
                'Authorization' => $config['token'],
                'Accept' => 'application/json',
            ])->withoutVerifying()
              ->timeout(30)
              ->get($url);
              
            $data = $response->json();
            
            return response()->json($data);
            
        } catch (\Exception $e) {
            \Log::error('Check FlexPay error', ['message' => $e->getMessage()]);
            return response()->json([
                'error' => 'Erreur vérification',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Callback FlexPay
     */
    public function callback(Request $request)
    {
        \Log::info('FlexPay Callback reçu', $request->all());
        
        try {
            $data = $request->json()->all() ?: $request->all();
            
            $reference = $data['reference'] ?? $data['Reference'] ?? null;
            $code = intval($data['code'] ?? $data['Code'] ?? -1);
            $transactionId = $data['transaction_id'] ?? $data['TransactionId'] ?? null;
            
            if (!$reference) {
                \Log::warning('Callback: Référence manquante');
                return response()->json(['error' => 'Reference manquante'], 400);
            }
            
            $paiement = Paiement::where('reference', $reference)->first();
            
            if (!$paiement) {
                \Log::warning('Callback: Paiement non trouvé', ['reference' => $reference]);
                return response()->json(['error' => 'Paiement introuvable'], 404);
            }
            
            $paiement->code_transaction = $transactionId;
            
            if ($code == 0) {
                $paiement->statut = 'PAID';
                $paiement->date_validation = now();
                \Log::info('Paiement validé', [
                    'reference' => $reference, 
                    'transaction' => $transactionId,
                    'montant' => $paiement->montant,
                    'devise' => $paiement->devise
                ]);
            } elseif ($code == 1) {
                $paiement->statut = 'FAILED';
                \Log::warning('Paiement échoué', ['reference' => $reference, 'code' => $code]);
            } elseif ($code == 2) {
                $paiement->statut = 'CANCELED';
                \Log::warning('Paiement annulé', ['reference' => $reference]);
            } else {
                $paiement->statut = 'FAILED';
            }
            
            $paiement->save();
            
            return response()->json(['message' => 'Callback traité']);
            
        } catch (\Exception $e) {
            \Log::error('Callback error', ['message' => $e->getMessage()]);
            return response()->json([
                'error' => 'Erreur callback',
                'details' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Afficher le reçu de paiement
     */
    public function showReceipt($id)
    {
        $paiement = Paiement::with(['eleve.classe', 'parent', 'frais'])
            ->findOrFail($id);

        if ($paiement->parent_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à voir ce reçu.');
        }

        return view('parent.recu', compact('paiement'));
    }

    /**
     * Télécharger le reçu au format PDF
     */
    public function downloadReceipt($id)
    {
        $paiement = Paiement::with(['eleve.classe', 'parent', 'frais'])
            ->findOrFail($id);

        if ($paiement->parent_id !== Auth::id()) {
            abort(403, 'Vous n\'êtes pas autorisé à télécharger ce reçu.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.recu', compact('paiement'));
        $pdf->setPaper('a4', 'portrait');
        
        return $pdf->download('recu_' . $paiement->reference . '.pdf');
    }
    
    /**
     * Vérifier le statut d'un paiement depuis la base (AJAX)
     */
    public function checkStatus($id)
    {
        $paiement = Paiement::findOrFail($id);
        
        if ($paiement->parent_id !== Auth::id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }
        
        return response()->json([
            'statut' => $paiement->statut,
            'reference' => $paiement->reference,
            'montant' => $paiement->montant,
            'montant_formate' => $this->formatMontantAffichage($paiement->montant, $paiement->devise),
            'devise' => $paiement->devise,
            'devise_symbole' => $paiement->devise === 'USD' ? '$' : 'FC',
            'code_transaction' => $paiement->code_transaction,
            'date_validation' => $paiement->date_validation,
        ]);
    }
}