<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FlexPayService
{
    protected $token;
    protected $merchant;
    protected $baseUrl;
    protected $verifySsl;

    public function __construct()
    {
        $this->token = env('FLEXPAY_TOKEN');
        $this->merchant = env('FLEXPAY_MERCHANT', 'QUINMBUKA');
        $this->baseUrl = env('FLEXPAY_MOBILE_URL', 'https://backend.flexpay.cd/api/rest/v1');
        // Désactiver SSL seulement en développement
        $this->verifySsl = app()->environment('production');
    }

    public function sendPayment($phone, $reference, $amount, $currency, $callbackUrl)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => $this->verifySsl,
            ])->timeout(30)->post($this->baseUrl . '/paymentService', [
                "merchant" => $this->merchant,
                "type" => "1",
                "phone" => $phone,
                "reference" => $reference,
                "amount" => $amount,
                "currency" => $currency,
                "callbackUrl" => $callbackUrl,
            ]);

            return $response;
        } catch (\Exception $e) {
            \Log::error('FlexPayService Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function checkStatus($reference)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => $this->verifySsl,
            ])->timeout(30)->post($this->baseUrl . '/check', [
                "merchant" => $this->merchant,
                "reference" => $reference,
            ]);

            return $response;
        } catch (\Exception $e) {
            \Log::error('FlexPayService Check Error: ' . $e->getMessage());
            throw $e;
        }
    }
}