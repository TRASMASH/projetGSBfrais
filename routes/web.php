<?php
use App\Http\Controllers\MédocController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisiteurController;
use App\Http\Controllers\FraisController;
use App\Http\Controllers\RapportController;

// PAGE D’ACCUEIL
Route::get('/', function () {
    return view('home');
});

// AUTHENTIFICATION fonctionelle normalment
Route::get('/connecter', [VisiteurController::class, 'login']);
Route::post('/authentifier', [VisiteurController::class, 'auth']);
Route::get('/deconnecter', [VisiteurController::class, 'logout']);

// FRAIS fonctionnelle
Route::get('/listerFrais', [FraisController::class, 'listFrais']);
Route::get('/ajouterFrais', [FraisController::class, 'addFrais']);
Route::post('/validerFrais', [FraisController::class, 'validFrais']);
Route::get('/editerFrais/{id}', [FraisController::class, 'editFrais']);

// RAPPORTS a ne pas modifier..
Route::get('/listerRapport', [RapportController::class, 'listRapport']);
Route::get('/ajouterRapport', [RapportController::class, 'addRapport']);
Route::post('/ajouterRapport', [RapportController::class, 'saveRapport']);
Route::get('/editerRapport/{id}', [RapportController::class, 'editRapport']);
Route::get('/rechercherRapport', [RapportController::class, 'rechercheRapport']);

// Médicament
Route::get('/topMedicaments', [MédocController::class, 'topMedicaments']);


Route::get('/editRapport/{id}', [RapportController::class, 'editRapport']);
Route::get('/modifierOffert/{id_rapport}/{id_medicament}', [RapportController::class, 'modifierOffert']);
Route::get('/supprimerOffert/{id_rapport}/{id_medicament}', [RapportController::class, 'supprimerOffert']);
Route::post('/saveModifierOffert', [RapportController::class, 'saveModifierOffert']);

Route::get('/listerRapport', [RapportController::class, 'listerRapport']);
Route::get('/ajouterOffert/{id_rapport}', [RapportController::class, 'ajouterOffert']);
Route::post('/saveOffert', [RapportController::class, 'saveOffert']);

Route::get('/topMedicaments',  [MédocController::class, 'topMedicaments']);



Route::get('/listeMedoc',      [MédocController::class, 'listeMedoc']);
Route::post('/rapportParMedoc', [MédocController::class, 'rapportParMedoc']);

