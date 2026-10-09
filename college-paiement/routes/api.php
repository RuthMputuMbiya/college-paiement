<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes API pour la simulation Mobile Money
Route::prefix('mobile-money')->group(function () {
    Route::post('airtel/pay', [MobileMoneySimulationController::class, 'simulateAirtel']);
    Route::post('orange/pay', [MobileMoneySimulationController::class, 'simulateOrange']);
    Route::post('mpesa/pay', [MobileMoneySimulationController::class, 'simulateMpesa']);
});