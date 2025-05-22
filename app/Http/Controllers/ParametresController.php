<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

/**
 * ParametresController
 *
 * Ce contrôleur gère les paramètres du site.
 */
class ParametresController extends Controller
{
    /**
     * Affiche la page des paramètres du site.
     *
     * @return \Illuminate\View\View
     */
    public function afficherParametres()
    {
        // on récupère les paramètres du site depuis la base de données
        $parametres = DB::table('parametres')->first();

        return view('admin.parametres', compact('parametres'));
    }

    /**
     * Met à jour le titre du site.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function majTitre(Request $request) {
        // on valide la requête
        $request->validate([
            'titre' => 'required|string|max:255',
        ]);

        // on met à jour le titre du site dans la base de données
        DB::table('parametres')->where('idParametre', 1)->update(['titreHeader' => $request->input('titre')]);

        return redirect()->route('admin.parametres')->with('success', 'Le titre du site a été mis à jour avec succès.');
    }

    /**
     * Met à jour les états du site.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function majModeService(Request $request) {
        $request->validate([
            'modeService' => 'required',
        ]);
        $modeService_bool = filter_var($request->input('modeService'), FILTER_VALIDATE_BOOLEAN);
        $modeService_bool = !$modeService_bool;
        DB::table('parametres')->where('idParametre', 1)->update(['service' => $modeService_bool]);
        return redirect()->route('admin.parametres')->with('success', 'Le mode service a été mis à jour.');
    }
}
