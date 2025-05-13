<?php

namespace App\Http\Controllers;

use App\Models\Releve;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalleSecuriteController extends Controller
{
    public function index()
    {
        // Récupérer les relevés de température (type = 0)
        $temperatureReleves = Releve::where('type', 0)->orderBy('date', 'desc')->get();

        // Récupérer les relevés de nettoyage (type = 1)
        $cleaningReleves = Releve::where('type', 1)->orderBy('date', 'desc')->get();

        // Préparer les données pour le graphique (15 derniers relevés)
        $lastTemperatureReleves = Releve::where('type', 0)->orderBy('date', 'desc')->take(15)->get()->reverse();

        $temperature1Values = $lastTemperatureReleves->pluck('temperature1');
        $temperature2Values = $lastTemperatureReleves->pluck('temperature2');

        return view('admin.salle-securite', [
            'temperatureReleves' => $temperatureReleves,
            'cleaningReleves' => $cleaningReleves,
            'temperatureDates' => $temperatureDates,
            'temperature1Values' => $temperature1Values,
            'temperature2Values' => $temperature2Values,
        ]);
    }

    public function ajouterReleveFrigo(Request $request)
    {
        $request->validate([
            'temperature1' => 'required|numeric',
            'temperature2' => 'required|numeric',
        ]);

        Releve::create([
            'type' => 0, // 0 = relevé température
            'temperature1' => $request->temperature1,
            'temperature2' => $request->temperature2,
            'nom' => Auth::user()->name, // Utilisation directe du nom de l'utilisateur connecté
            'numeroCompte' => Auth::id(),
            // La date est automatiquement remplie par le timestamp
        ]);

        return redirect()->route('admin.salle-securite')->with('success', 'Relevé de température ajouté avec succès');
    }

    public function ajouterNettoyage(Request $request)
    {
        $request->validate([
            'commentaire' => 'required|string|max:255',
        ]);

        Releve::create([
            'type' => 1, // 1 = nettoyage
            'commentaire' => $request->commentaire,
            'nom' => Auth::user()->name, // Utilisation directe du nom de l'utilisateur connecté
            'numeroCompte' => Auth::id(),
            // La date est automatiquement remplie par le timestamp
        ]);

        return redirect()->route('admin.salle-securite')->with('success', 'Nettoyage enregistré avec succès');
    }
}
