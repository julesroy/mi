<?php

use App\Http\Controllers\GestionComptesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\CommandeCuisineController;
use App\Http\Controllers\GestionStocksController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\SalleSecuriteController;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\CommandeUtilisateurController;
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

// page commander
Route::get('/commander', [CommandeUtilisateurController::class, 'index'])->middleware('auth');

/**-----------------------------------------------
 * ADMIN
 -----------------------------------------------*/

// Groupe de middlewares pour les pages admin : utilisateur authentifié, avec au minimum l'accès serveur
Route::prefix('admin')->group(function () {

    // page panneau admin
    Route::get('/panneau-admin', function () {
        return view('panneau-admin');
    });

    // page Gestion stocks
    Route::get('/gestion-stocks', [GestionStocksController::class, 'index']);

    // Routes pour la gestion des ingrédients
    Route::get('/inventaire', [IngredientController::class, 'index']);
    Route::post('/ingredients/store', [IngredientController::class, 'store'])->name('ingredients.store');
    Route::post('/ingredients/update', [IngredientController::class, 'update'])->name('ingredients.update');
    Route::post('/ingredients/delete', [IngredientController::class, 'delete'])->name('ingredients.delete');


    // Page de planning
    Route::get('/planning', [PlanningController::class, 'afficher']);
    Route::get('/planning/data/{month}', [PlanningController::class, 'donnees']);
    Route::delete('/planning/supprimer-inscription/{idInscription}', [PlanningController::class, 'supprimer']);
    Route::post('/planning/ajouter-inscription', [PlanningController::class, 'ajouter']);

    //page gestion des comptes
    Route::get('/gestion-comptes', [GestionComptesController::class, 'afficherComptes'])
        ->name('gestion-comptes');

    // page de gestion de la carte
    Route::get('/gestion-carte', [CarteController::class, 'afficherGestionCarte'])
        ->middleware('auth')
        ->middleware('can:verifier-acces-serveur');
    Route::post('/carte/ajouter', [CarteController::class, 'ajouter'])->name('carte.ajouter');

    // page Salle et sécurité
    Route::get('/salle-securite', function () {
        return view('admin.salle-securite');
    });
    Route::prefix('/salle-securite')->group(function () {
        Route::get('salle-securite', [SalleSecuriteController::class, 'index'])
            ->name('admin.salle-securite');
            
        Route::post('salle-securite/ajouter-releve-frigo', [SalleSecuriteController::class, 'ajouterReleveFrigo'])
            ->name('admin.salle-securite.ajouter-releve-frigo');
            
        Route::post('salle-securite/ajouter-nettoyage', [SalleSecuriteController::class, 'ajouterNettoyage'])
            ->name('admin.salle-securite.ajouter-nettoyage');
    });

    // Page de validation/modifier... des commande 
    Route::prefix('commandes')->group(function () {
        Route::get('/', [CommandeCuisineController::class, 'index'])
            ->name('admin.commandes.index');

        Route::get('/data', [CommandeCuisineController::class, 'getCommandes'])
            ->name('admin.commandes.data');

        Route::post('/commande-prete/{id}', [CommandeCuisineController::class, 'marquerCommandePrete'])
            ->name('admin.commandes.marquer-prete');

        Route::post('/commande-donnee/{id}', [CommandeCuisineController::class, 'marquerCommandeServie'])
            ->name('admin.commandes.marquer-servie');

        Route::post('/modifier-commande/{id}', [CommandeCuisineController::class, 'modifierCommande'])
            ->name('admin.commandes.modifier');

        Route::post('/annuler-commande/{id}', [CommandeCuisineController::class, 'annulerCommande'])
            ->name('admin.commandes.annuler');
    });

    Route::get('/commandes', function () {
        return view('admin.commandes');
    });
})->middleware(['auth', 'can:verifier-acces-serveur']);

// page contact
Route::get('/contact', function () {
    return view('contact');
});

// page politiques de donnees
Route::get('/politiques-donnees', function () {
    return view('politiques-donnees');
});

//page mentions légales
Route::get('/mentions-legales', function () {
    return view('mentions-legales');
});

// page réglement
Route::get('/reglement', function () {
    return view('reglement');
});

// page carte
Route::get('/carte', function () {
    return view('carte');
});

// page actus
Route::get('/actus', function () {
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
