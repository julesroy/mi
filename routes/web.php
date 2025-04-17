<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;

// accueil
Route::get('/', function () {
    return view('welcome');
});

// connexion
Route::get('/connexion', [AuthController::class, 'afficherFormulaireConnexion'])->name('connexion');
Route::post('/connexion', [AuthController::class, 'connecter']);

// page compte
Route::get('/compte', function () {
    return 'Bienvenue dans ton espace personnel !';
})->middleware('auth');

Route::get('/info', function () {
    return view('info');
});

Route::get('/test-bdd', function () {
    try {
        DB::connection()->getPdo();
        return '✅ Connexion à la base de données réussie !';
    } catch (\Exception $e) {
        return '❌ Erreur : ' . $e->getMessage();
    }
});