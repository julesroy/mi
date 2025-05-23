<?php

namespace App\Http\Controllers;

use App\Models\ReleveSalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * SalleSecuriteController
 *
 * Ce contrôleur gère l'affichage de la page de la salle de sécurité.
 * Il récupère les relevés de température et les relevés de nettoyage.
 */
class SalleSecuriteController extends Controller
{
    /**
     * Affiche la page de la salle de sécurité.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $temperatureReleves = ReleveSalle::with('utilisateur')
            ->where('type', 0)
            ->orderBy('date', 'desc')
            ->get();

        $cleaningReleves = ReleveSalle::with('utilisateur')
            ->where('type', 1)
            ->orderBy('date', 'desc')
            ->get();

        // Préparer les données du graphique
        $lastTemperatureReleves = ReleveSalle::with('utilisateur')
            ->where('type', 0)
            ->orderBy('date', 'desc')
            ->take(15)
            ->get()
            ->reverse(); // Pour avoir les données dans l'ordre chronologique

        $chartData = [
            'dates' => $lastTemperatureReleves->map(function ($item) {
                return Carbon::parse($item->date)->format('d/m H:i');
            })->values(),
            'temp1' => $lastTemperatureReleves->pluck('temperature1')->values(),
            'temp2' => $lastTemperatureReleves->pluck('temperature2')->values()
        ];

        return view('admin.salle-securite', compact(
            'temperatureReleves',
            'cleaningReleves',
            'chartData'
        ));
    }

    /**
     * Enregistre un relevé de température dans la base de données.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ajouterReleveFrigo(Request $request)
    {
        $validated = $request->validate([
            'temperature1' => 'required|numeric',
            'temperature2' => 'required|numeric',
        ]);

        ReleveSalle::insert([
            'type' => 0,
            'temperature1' => $validated['temperature1'],
            'temperature2' => $validated['temperature2'],
            'idUtilisateur' => Auth::id(),
            'date' => now()->timezone('Europe/Stockholm'), // S'assurer que la date est bien renseignée
        ]);

        return back()->with('success', 'Relevé enregistré !');
    }

    /**
     * Enregistre un relevé de nettoyage dans la base de données.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function ajouterNettoyage(Request $request)
    {
        $validated = $request->validate([
            'commentaire' => 'required|string|max:255'
        ]);

        ReleveSalle::insert([
            'type' => 1,
            'temperature1' => 0,
            'temperature2' => 0,
            'commentaire' => $validated['commentaire'],
            'idUtilisateur' => Auth::id(),
            'date' => now(), // idem
        ]);

        return back()->with('success', 'Nettoyage enregistré !');
    }
}
