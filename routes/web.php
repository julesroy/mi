<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\GestionStocksController;
use App\Http\Controllers\IngredientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// accueil
Route::get('/', function () {
    return view('accueil');
});

// connexion
Route::get('/connexion', [AuthController::class, 'afficherFormulaireConnexion'])->middleware('guest')->name('connexion');
Route::post('/connexion', [AuthController::class, 'connecter'])->middleware('messagethrottle:2,1'); // on limite le nombre de tentatives de connexion à 2 par minute (à assouplir plus tard mais là c'est pour les tests)

// inscription
Route::get('/inscription', [AuthController::class, 'afficherFormulaireInscription'])->middleware('guest')->name('inscription');
Route::post('/inscription', [AuthController::class, 'inscrire'])->middleware('messagethrottle:2,1'); // on limite le nombre de tentatives de connexion à 2 par minute (à assouplir plus tard mais là c'est pour les tests)

// déconnexion
Route::get('/deconnexion', [AuthController::class, 'deconnecter'])->middleware('auth');

// page compte
Route::get('/compte', function () {
    return view('compte');
})->middleware('auth');


Route::get('/commander', function () {
    return view('commander');
});

/**-----------------------------------------------
 * ADMIN
 -----------------------------------------------*/

// page panneau admin
Route::get('/panneau-admin', function () {
    return view('panneau-admin');
});

// page Gestion stocks
Route::get('/admin/gestion-stocks', [GestionStocksController::class, 'index'])->middleware('auth');

// Routes pour la gestion des ingrédients
Route::get('/admin/inventaire', [IngredientController::class, 'index'])->middleware('auth');
Route::post('/admin/ingredients/store', [IngredientController::class, 'store'])->name('ingredients.store')->middleware('auth');
Route::post('/admin/ingredients/update', [IngredientController::class, 'update'])->name('ingredients.update')->middleware('auth');
Route::post('/admin/ingredients/delete', [IngredientController::class, 'delete'])->name('ingredients.delete')->middleware('auth');


// Page de planning
Route::get('/admin/planning', [PlanningController::class, 'afficher'])
    ->middleware('auth')
    ->middleware('can:verifier-acces-serveur')
    ->middleware('adminAccess');

Route::post('/admin/planning/supprimer-inscription', [PlanningController::class, 'supprimer'])
    ->middleware('auth')
    ->middleware('can:verifier-acces-serveur')
    ->middleware('adminAccess');


// page contact
Route::get('/contact', function() {
    return view('contact');
});

// page politiques de donnees
Route::get('/politiques-donnees', function() {
    return view('politiques-donnees');
});

//page mentions légales
Route::get('/mentions-legales', function() {
    return view('mentions-legales');
});

// page réglement
Route::get('/reglement', function() {
    return view('reglement');
});

// page carte
Route::get('/carte', function() {
    return view('carte');
});

// page actus
Route::get('/actus', function() {
    return view('actus');
});

/**-----------------------------------------------
 * DEBUG
 -----------------------------------------------*/

// affiche le php.ini NE PAS METTRE EN PRODUCTION
Route::get('/debug/info', function () {
    return view('info');
})->middleware('can:verifier-acces-administrateur');

// test de la connexion à la base de données NE PAS METTRE EN PRODUCTION
Route::get('/debug/test-bdd', function () {
    try {
        DB::connection()->getPdo();
        return '✅ Connexion à la base de données réussie !';
    } catch (\Exception $e) {
        return '❌ Erreur : ' . $e->getMessage();
    }
})->middleware('can:verifier-acces-administrateur');

// affichage des données de la session
Route::get('/debug/session', function (Request $request) {
    return view('session', ['session' => $request->session()->all(), 'id' => Auth::id()]);
})->middleware('can:verifier-acces-administrateur');