<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConfigurationMobileMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MobileMoneySimulationController extends Controller
{
    public function simulateAirtel(Request $request)
    {
        return $this->simulatePayment('airtel', $request);
    }
    
    public function simulateOrange(Request $request)
    {
        return $this->simulatePayment('orange', $request);
    }
    
    public function simulateMpesa(Request $request)
    {
        return $this->simulatePayment('mpesa', $request);
    }
    
    private function simulatePayment($operator, $request)
    {
        $config = ConfigurationMobileMoney::where('operateur', $operator)
            ->where('statut', 'actif')
            ->first();
        
        $delai = $config->delai_simulation_ms ?? 2000;
        $tauxSucces = $config->parametres['taux_succes'] ?? 95;
        
        // Simuler le délai
        usleep($delai * 1000);
        
        $success = rand(1, 100) <= $tauxSucces;
        
        if ($success) {
            return response()->json([
                'success' => true,
                'code' => '00',
                'message' => 'Transaction approuvée',
                'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
                'operator' => $operator,
                'amount' => $request->montant,
                'phone' => $request->numero_mobile,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'code' => '99',
                'message' => 'Transaction échouée. Solde insuffisant.',
                'operator' => $operator,
            ], 400);
        }
    }
}