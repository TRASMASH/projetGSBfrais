<?php

use App\Http\Controllers\FraisController;
use App\Http\Controllers\VisiteurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post ('/visiteur/initpwd',[VisiteurController::class,'initPasswordAPI']);
Route::post('/visiteur/auth',[VisiteurController::class,'authAPI']);
Route::get('/visiteur/logout',[VisiteurController::class,'logoutAPI'])->middleware('auth:sanctum');;
Route::get('/visiteur/unauthorized',[VisiteurController::class,'unauthorizedAPI'])->name('login');
Route::get('/frais/{idFrais}',[FraisController::class,'getFraisAPI'])->middleware('auth:sanctum');
Route::post('/frais/ajout', [FraisController::class, 'addFraisAPI']);
Route::post('/frais/modif', [FraisController::class, 'updateFraisAPI']);
Route::delete('/frais/suppr', [FraisController::class, 'removeFraisAPI']);
