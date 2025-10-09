<?php

use App\Http\Controllers\visiteurController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FraisController;

Route::get('/', function () {
    return view('home');});

Route::get ('/connecter',[VisiteurController::class,'login']);

Route::post('/authentifier',[VisiteurController::class,'auth']);

Route::get('/deconnecter',[VisiteurController::class,'logout']);
Route::get('/deconnecter', [VisiteurController::class, 'logout']);
Route::get('/listerFrais',[FraisController::class,'listFrais']);
Route::get('/ajouterFrais',[FraisController::class,'addFrais']);
Route::post('/validerFrais',[FraisController::class,'validFrais']);
Route::get('/editerFrais/{id}',[FraisController::class,'editFrais']);
