<?php

use App\Http\Controllers\FraisController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\VisiteurController;
use App\Http\Controllers\MédocController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/visiteur/initpwd', [VisiteurController::class, 'initPasswordAPI']);
Route::post('/visiteur/auth', [VisiteurController::class, 'authAPI']);
Route::get('/visiteur/logout', [VisiteurController::class, 'logoutAPI'])->middleware('auth:sanctum');
Route::get('/visiteur/unauthorized', [VisiteurController::class, 'unauthorizedAPI'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/frais/{idFrais}', [FraisController::class, 'getFraisAPI']);
    Route::post('/frais/ajout', [FraisController::class, 'addFraisAPI']);
    Route::post('/frais/modif', [FraisController::class, 'updateFraisAPI']);
    Route::delete('/frais/suppr', [FraisController::class, 'removeFraisAPI']);
    Route::get('/frais/liste/{idVisiteur}', [FraisController::class, 'listFraisAPI']);

    Route::get('/rapport/liste', [RapportController::class, 'listRapportAPI']);
    Route::get('/rapport/ajout', [RapportController::class, 'addRapportAPI']);
    Route::post('/rapport/ajout', [RapportController::class, 'storeRapportAPI']);

    Route::get('/medicament/liste', [MédocController::class, 'topMedicamentsAPI']);

    Route::get('/rapport/{id_rapport}/medicaments', [RapportController::class, 'getMedicamentsOffertsAPI']);
    Route::post('/rapport/modifier-offert', [RapportController::class, 'updateOffertAPI']);
    Route::post('/rapport/ajouter-offert', [RapportController::class, 'addOffertAPI']);
    Route::delete('/rapport/supprimer-offert', [RapportController::class, 'deleteOffertAPI']);
    Route::get('/medicaments', [RapportController::class, 'getMedicamentsAPI']);

    Route::get('/rapport/lister', [RapportController::class, 'listerRapportAPI'])->middleware('auth:sanctum');
});
