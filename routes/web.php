<?php

use App\Http\Controllers\GestionComptesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ActualitesController;
use App\Http\Controllers\ActuController;
use App\Http\Controllers\CompteController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\PriseCommandeController;
use App\Http\Controllers\CommandeCuisineController;
use App\Http\Controllers\GestionStocksController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\SalleSecuriteController;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\CommandeUtilisateurController;
use App\Http\Controllers\TresorerieController;
use App\Http\Controllers\AffichageCuisineController;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\ParametresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


/**-----------------------------------------------
 * UTILISATEUR
 -----------------------------------------------*/

// page d'accueil
Route::get('/', [AccueilController::class, 'afficher'])
    ->name('accueil');

// page de connexion
Route::get('/connexion', [AuthController::class, 'afficherFormulaireConnexion'])->middleware('guest')->name('connexion');
Route::post('/connexion', [AuthController::class, 'connecter'])->middleware('messagethrottle:2,1'); // on limite le nombre de tentatives de connexion à 2 par minute (à assouplir plus tard mais là c'est pour les tests)

// page d'inscription
Route::get('/inscription', [AuthController::class, 'afficherFormulaireInscription'])->middleware('guest')->name('inscription');
Route::post('/inscription', [AuthController::class, 'inscrire'])->middleware('messagethrottle:2,1'); // on limite le nombre de tentatives de connexion à 2 par minute (à assouplir plus tard mais là c'est pour les tests)

// déconnexion
Route::get('/deconnexion', [AuthController::class, 'deconnecter']);

// routes associées au compte utilisateur
Route::prefix('/compte')->group(function () {
    // page du compte compte
    Route::get('/', [CompteController::class, 'show'])->name('compte')->middleware('auth');

    // page de changement de mot de passe
    Route::get('/changement-mdp/{token}', function (string $token) {
        return view('changement-mdp', ['token' => $token]);
    });
    Route::post('/changement-mdp', [CompteController::class, 'resetPassword']);

    // requête de mail pour mdp perdu, nécessite d'être un guest
    Route::post('/mdp-perdu', [CompteController::class, 'lostPassword'])->middleware('guest');
});

// page de commande côté utilisateur
Route::get('/commander', [CommandeUtilisateurController::class, 'index']);
Route::post('/commander/valider', [CommandeUtilisateurController::class, 'validerCommande'])->name('commander.valider');

// page de contact
Route::get('/contact', function () {
    return view('contact');
});

// page politique de données
Route::get('/politiques-donnees', function () {
    return view('politiques-donnees');
});

//page des mentions légales
Route::get('/mentions-legales', function () {
    return view('mentions-legales');
});

// page du règlement
Route::get('/reglement', function () {
    return view('reglement');
});

// page de la carte
Route::get('/carte', function () {
    return view('carte');
});

// page des actus
Route::get('/actus', [ActualitesController::class, 'index'])->name('actus');

/**-----------------------------------------------
 * ADMIN
 -----------------------------------------------*/

// groupe de middlewares pour les pages admin : utilisateur authentifié, avec au minimum l'accès serveur
Route::prefix('admin')->group(function () {


    // page de la trésorerie
    Route::get('/tresorerie', [TresorerieController::class, 'afficher'])
        ->middleware('can:verifier-acces-super-administrateur')
        ->name('admin.tresorerie');

    // page du panneau d'administration
    Route::get('/panneau-admin', function () {
        return view('admin.panneau-admin');
    })->middleware('can:verifier-acces-serveur');

    // prise de commande c^té administrateur
    Route::get('/prise-commande', [PriseCommandeController::class, 'index'])->name('prise-commande');

    // page de l'affichage des commandes en cuisine
    Route::get('/affichage-cuisine', [AffichageCuisineController::class, 'afficher', 'updateEtat'])
        ->middleware('can:verifier-acces-serveur')
        ->name('admin.affichage-cuisine');

    // page des paramètres du site
    Route::prefix('/parametres')->group(function () {
        Route::get('/', [ParametresController::class, 'afficherParametres'])
            ->middleware('can:verifier-acces-super-administrateur')
            ->name('admin.parametres');
        Route::post('/majTitre', [ParametresController::class, 'majTitre'])
            ->middleware('can:verifier-acces-super-administrateur')
            ->name('admin.parametres.majTitre');
        Route::post('/admin/parametres/mode-service', [ParametresController::class, 'majModeService'])
            ->middleware('can:verifier-acces-super-administrateur')
            ->name('admin.parametres.modeService');
        Route::post('/admin/parametres/majLogo', [ParametresController::class, 'majLogo'])->name('admin.parametres.majLogo');
    });


    // page de la gestion des stocks
    Route::get('/gestion-stocks', [GestionStocksController::class, 'index']);

    // routes pour la gestion de l'inventaire
    Route::get('/inventaire', [IngredientController::class, 'index']);
    Route::post('/ingredients/store', [IngredientController::class, 'store'])->name('ingredients.store');
    Route::post('/ingredients/update', [IngredientController::class, 'update'])->name('ingredients.update');
    Route::post('/ingredients/delete', [IngredientController::class, 'delete'])->name('ingredients.delete');

    // gestion des actus
    Route::get('/gestion-actus', [ActuController::class, 'index'])->name('gestion-actus');
    Route::get('/gestion-actus/ajouter', [ActuController::class, 'create'])->name('actus.create');
    Route::post('/gestion-actus', [ActuController::class, 'store'])->name('actus.store');
    Route::get('/gestion-actus/{id}/edit', [ActuController::class, 'edit'])->name('actus.edit');
    Route::put('/gestion-actus/{id}', [ActuController::class, 'update'])->name('actus.update');
    Route::delete('/gestion-actus/{id}', [ActuController::class, 'destroy'])->name('actus.destroy');



    // page du planning
    Route::get('/planning', [PlanningController::class, 'afficher']);
    Route::get('/planning/data/{month}', [PlanningController::class, 'donnees']);
    Route::delete('/planning/supprimer-inscription/{idInscription}/{newDate}', [PlanningController::class, 'supprimer']);
    Route::post('/planning/ajouter-inscription', [PlanningController::class, 'ajouter']);

    // page gestion des comptes
    Route::prefix('/gestion-comptes')->group(function () {
        Route::get('/', [GestionComptesController::class, 'afficherComptes'])
            ->middleware('can:verifier-acces-super-administrateur')
            ->name('admin.gestion-comptes');
        Route::post('/update', [GestionComptesController::class, 'update'])
            ->middleware('can:verifier-acces-super-administrateur')
            ->name('admin.gestion-comptes.update');
    });

    // page de gestion de la carte
    Route::prefix('/gestion-carte')->group(function () {
        Route::get('/', [CarteController::class, 'afficherGestionCarte'])
            ->middleware('can:verifier-acces-serveur')
            ->name('admin.gestion-carte');
        Route::post('/ajouter', [CarteController::class, 'ajouter'])->name('admin.gestion-carte.ajouter');
        Route::post('/modifier', [CarteController::class, 'modifier'])->name('admin.gestion-carte.modifier');
        Route::post('/supprimer', [CarteController::class, 'supprimer'])->name('admin.gestion-carte.supprimer');
    });
    
    // page de la gestion "salle et sécurité"
    Route::prefix('/salle-securite')->group(function () {
        Route::get('/', [SalleSecuriteController::class, 'index'])
            ->name('admin.salle-securite');

        Route::post('/ajouter-releve-frigo', [SalleSecuriteController::class, 'ajouterReleveFrigo'])
            ->name('admin.salle-securite.ajouter-releve-frigo');

        Route::post('/ajouter-nettoyage', [SalleSecuriteController::class, 'ajouterNettoyage'])
            ->name('admin.salle-securite.ajouter-nettoyage');
    });

    // pages de validation, modification, etc... des commandes
    Route::prefix('commandes')->group(function () {
        Route::get('/', [CommandeCuisineController::class, 'index'])
            ->name('admin.commandes.index');

        Route::get('/data', [CommandeCuisineController::class, 'getCommandes'])
            ->name('admin.commandes.data');

        Route::get('/details/{id}', [CommandeCuisineController::class, 'getCommandeDetails']);

        Route::get('/inventaire/items', [CommandeCuisineController::class, 'getInventaireItems']);

        Route::post('/commande-payee/{id}', [CommandeCuisineController::class, 'marquerCommandePayee'])
            ->name('admin.commandes.marquer-payee');

        Route::post('/commande-prete/{id}', [CommandeCuisineController::class, 'marquerCommandePrete'])
            ->name('admin.commandes.marquer-prete');

        Route::post('/commande-donnee/{id}', [CommandeCuisineController::class, 'marquerCommandeServie'])
            ->name('admin.commandes.marquer-servie');

        Route::post('/modifier-commande/{id}', [CommandeCuisineController::class, 'modifierCommande'])
            ->name('admin.commandes.modifier');

        Route::post('/annuler-commande/{id}', [CommandeCuisineController::class, 'annulerCommande'])
            ->name('admin.commandes.annuler');
    });

    // page de gestion des commandes
    Route::get('/commandes', function () {
        return view('admin.commandes');
    });
})->middleware('can:verifier-acces-serveur');


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
