<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

// ==================== CONTROLLERS GESTIONNAIRE ====================
use App\Http\Controllers\Gestionnaire\DashboardController as GestionnaireDashboardController;
use App\Http\Controllers\Gestionnaire\UserController as GestionnaireUserController;
use App\Http\Controllers\Gestionnaire\PaymentController as GestionnairePaymentController;
use App\Http\Controllers\Gestionnaire\PaymentConfigController as GestionnairePaymentConfigController;
use App\Http\Controllers\Gestionnaire\LogController as GestionnaireLogController;
use App\Http\Controllers\Gestionnaire\StatistiqueController as GestionnaireStatistiqueController;


// Contrôleurs Comptable
use App\Http\Controllers\Comptable\DashboardController as ComptableDashboardController;
use App\Http\Controllers\Comptable\EleveController as ComptableEleveController;
use App\Http\Controllers\Comptable\ClasseController as ComptableClasseController;
use App\Http\Controllers\Comptable\FraisController as ComptableFraisController;
use App\Http\Controllers\Comptable\PaiementController as ComptablePaiementController;
use App\Http\Controllers\Comptable\LitigeController as ComptableLitigeController;
use App\Http\Controllers\Comptable\StatistiqueController as ComptableStatistiqueController;

// Contrôleurs Parent
use App\Http\Controllers\Parent\DashboardController as ParentDashboardController;
use App\Http\Controllers\Parent\PaiementController as ParentPaiementController;
use App\Http\Controllers\Parent\ProfileController as ParentProfileController;
use App\Http\Controllers\Parent\PaiementController;

// Contrôleurs Élève
use App\Http\Controllers\Eleve\AuthController as EleveAuthController;
use App\Http\Controllers\Eleve\DashboardController as EleveDashboardController;
use App\Http\Controllers\Eleve\ProfileController as EleveProfileController;

// Contrôleurs API
use App\Http\Controllers\Api\MobileMoneySimulationController;

/*
|--------------------------------------------------------------------------
| Page d'accueil
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Routes d'authentification (Public)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Connexion
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    
    // Inscription parent
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    
    // Mot de passe oublié
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// Déconnexion
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard de redirection
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = Auth::user();
    
    if ($user->role === 'gestionnaire_systeme') {
        return redirect()->route('gestionnaire.dashboard');
    } elseif ($user->role === 'comptable') {
        return redirect()->route('comptable.dashboard');
    } elseif ($user->role === 'parent') {
        return redirect()->route('parent.dashboard');
    }
    
    return redirect('/');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Routes Profil (Laravel Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Routes GESTIONNAIRE SYSTÈME
|--------------------------------------------------------------------------
*/
// ==================== ROUTES GESTIONNAIRE SYSTÈME ====================
Route::prefix('gestionnaire')->name('gestionnaire.')->middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('dashboard', [GestionnaireDashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des utilisateurs
    Route::resource('users', GestionnaireUserController::class);
    
    // Gestion des paiements
    Route::get('payments', [GestionnairePaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/{id}', [GestionnairePaymentController::class, 'show'])->name('payments.show');
    
    // Configuration des paiements
    Route::get('payment-config', [GestionnairePaymentConfigController::class, 'index'])->name('payment-config.index');
    Route::put('payment-config/{id}', [GestionnairePaymentConfigController::class, 'update'])->name('payment-config.update');
    
    // Logs système
    Route::get('logs', [GestionnaireLogController::class, 'index'])->name('logs.index');
    
    // Statistiques
    Route::get('statistiques', [GestionnaireStatistiqueController::class, 'index'])->name('statistiques.index');
});



/*
|--------------------------------------------------------------------------
| Routes COMPTABLE
|--------------------------------------------------------------------------
*/
Route::prefix('comptable')->name('comptable.')->middleware(['auth', 'check.status'])->group(function () {
    
    // Dashboard
    Route::get('dashboard', [ComptableDashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des élèves
    Route::resource('eleves', ComptableEleveController::class);
    
    // Gestion des classes
    Route::resource('classes', ComptableClasseController::class);
    
    // Gestion des frais
    Route::resource('frais', ComptableFraisController::class);
    
    // Gestion des paiements
    Route::get('paiements', [ComptablePaiementController::class, 'index'])->name('paiements.index');
    Route::get('paiements/{id}', [ComptablePaiementController::class, 'show'])->name('paiements.show');
    Route::post('paiements/{id}/validate', [ComptablePaiementController::class, 'validatePayment'])->name('paiements.validate');
    Route::get('paiements/{id}/receipt', [ComptablePaiementController::class, 'downloadReceipt'])->name('paiements.receipt');
    
    // Gestion des litiges
    Route::resource('litiges', ComptableLitigeController::class);
    
    // Statistiques
    Route::get('statistiques', [ComptableStatistiqueController::class, 'index'])->name('statistiques.index');
    Route::get('statistiques/data', [ComptableStatistiqueController::class, 'getData'])->name('statistiques.data');
       // Gestion des parents
    Route::resource('parents', App\Http\Controllers\Comptable\ParentController::class);
    
    

    });

/*
|--------------------------------------------------------------------------
| Routes PARENT
|--------------------------------------------------------------------------
*/
Route::prefix('parent')->name('parent.')->middleware(['auth', 'check.status'])->group(function () {
    
    // Dashboard
    Route::get('dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
    
    // Mes enfants
    Route::get('enfants', [ParentDashboardController::class, 'enfants'])->name('enfants');
    
    // Historique des paiements
    Route::get('historique', [ParentDashboardController::class, 'historique'])->name('historique');
    
    //  Routes paiement
    Route::get('paiement', [PaiementController::class, 'showPaymentForm'])->name('paiement.form');
    Route::post('paiement', [PaiementController::class, 'processPayment'])->name('paiement.process');
    // Reçu
    Route::get('recu/{id}', [ParentPaiementController::class, 'showReceipt'])->name('recu.show');
    Route::get('recu/{id}/download', [ParentPaiementController::class, 'downloadReceipt'])->name('recu.download');
    
    // Routes profil
    Route::get('profile/edit', [App\Http\Controllers\Parent\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [App\Http\Controllers\Parent\ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [App\Http\Controllers\Parent\ProfileController::class, 'updatePassword'])->name('profile.password');
    });

/*
|--------------------------------------------------------------------------
| Routes ÉLÈVE
|--------------------------------------------------------------------------
*/
// Routes publiques élève (login)
Route::prefix('eleve')->name('eleve.')->middleware('guest')->group(function () {
    Route::get('login', [EleveAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [EleveAuthController::class, 'login']);
    Route::post('logout', [EleveAuthController::class, 'logout'])->name('logout');
});

// Routes protégées élève
// Routes Élève
Route::prefix('eleve')->name('eleve.')->group(function () {
    // Connexion (publique)
    Route::get('login', [App\Http\Controllers\Eleve\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Eleve\AuthController::class, 'login']);
    Route::post('logout', [App\Http\Controllers\Eleve\AuthController::class, 'logout'])->name('logout');
    
    // Changement de mot de passe (première connexion) - public
    Route::get('profile/edit-password', [App\Http\Controllers\Eleve\ProfileController::class, 'editPassword'])->name('profile.edit-password');
    Route::put('profile/update-password', [App\Http\Controllers\Eleve\ProfileController::class, 'updatePassword'])->name('profile.update-password');
});

// Routes protégées élève
Route::prefix('eleve')->name('eleve.')->middleware(['eleve.auth'])->group(function () {
    Route::get('dashboard', [App\Http\Controllers\Eleve\DashboardController::class, 'index'])->name('dashboard');
    Route::get('paiements', [App\Http\Controllers\Eleve\DashboardController::class, 'paiements'])->name('paiements');
    Route::get('profile', [App\Http\Controllers\Eleve\ProfileController::class, 'index'])->name('profile.index');
    Route::get('recu/{id}', [App\Http\Controllers\Eleve\ProfileController::class, 'downloadReceipt'])->name('recu.download');
});





/*
|--------------------------------------------------------------------------
| Routes API (Simulation Mobile Money)
|--------------------------------------------------------------------------
*/
Route::prefix('api')->name('api.')->middleware('api')->group(function () {
    Route::post('simulate/airtel', [MobileMoneySimulationController::class, 'simulateAirtel']);
    Route::post('simulate/orange', [MobileMoneySimulationController::class, 'simulateOrange']);
    Route::post('simulate/mpesa', [MobileMoneySimulationController::class, 'simulateMpesa']);
});

// Inclure les routes d'authentification supplémentaires

// Routes pour les parents (avec middleware auth)
Route::middleware(['auth'])->prefix('parent')->name('parent.')->group(function () {
    
    // Paiement
    Route::get('paiement/form', [App\Http\Controllers\Parent\PaiementController::class, 'showPaymentForm'])->name('paiement.form');
    Route::post('paiement/process', [App\Http\Controllers\Parent\PaiementController::class, 'processPayment'])->name('paiement.process');
    Route::get('recu/{id}', [App\Http\Controllers\Parent\PaiementController::class, 'showReceipt'])->name('recu.show');
    Route::get('recu/{id}/download', [App\Http\Controllers\Parent\PaiementController::class, 'downloadReceipt'])->name('recu.download');
    Route::get('paiement/status/{id}', [App\Http\Controllers\Parent\PaiementController::class, 'checkStatus'])->name('paiement.status');
});

// Route pour le callback FlexPay (sans middleware auth)
Route::post('flexpay/callback', [App\Http\Controllers\Parent\PaiementController::class, 'callback'])->name('flexpay.callback');

// Routes pour les appels AJAX
Route::middleware(['auth'])->group(function () {
    Route::get('/parent/get-classes', [App\Http\Controllers\Parent\PaiementController::class, 'getClasses'])->name('parent.getClasses');
    Route::get('/parent/get-operateurs', [App\Http\Controllers\Parent\PaiementController::class, 'getOperateurs'])->name('parent.getOperateurs');
    Route::get('/parent/get-enfants', [App\Http\Controllers\Parent\PaiementController::class, 'getEnfants'])->name('parent.getEnfants');
    Route::get('/parent/get-frais', [App\Http\Controllers\Parent\PaiementController::class, 'getFrais'])->name('parent.getFrais');
});
require __DIR__.'/auth.php';