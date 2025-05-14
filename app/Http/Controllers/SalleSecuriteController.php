<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SalleSecuriteController extends Controller
{
    public function index()
    {
        $temperatureReleves = DB::table('salleEtSecurite')
                            ->where('type', 0)
                            ->orderBy('date', 'desc')
                            ->get();

        $cleaningReleves = DB::table('salleEtSecurite')
                             ->where('type', 1)
                             ->orderBy('date', 'desc')
                             ->get();

        $lastTemperatureReleves = DB::table('salleEtSecurite')
                                    ->where('type', 0)
                                    ->orderBy('date', 'desc')
                                    ->take(15)
                                    ->get()
                                    ->reverse();

        $chartData = [
            'dates' => collect($lastTemperatureReleves)->map(function($item) {
                return Carbon::parse($item->date)->format('d/m H:i');
            }),
            'temp1' => collect($lastTemperatureReleves)->pluck('temperature1'),
            'temp2' => collect($lastTemperatureReleves)->pluck('temperature2')
        ];

        return view('admin.salle-securite', compact(
            'temperatureReleves',
            'cleaningReleves',
            'chartData'
        ));
    }

    public function ajouterReleveFrigo(Request $request)
    {
        $validated = $request->validate([
            'temperature1' => 'required|numeric',
            'temperature2' => 'required|numeric',
        ]);

        DB::table('salleEtSecurite')->insert([
            'type' => 0,
            'temperature1' => $validated['temperature1'],
            'temperature2' => $validated['temperature2'],
            'nom' => Auth::user()->nom . ' ' . Auth::user()->prenom,
            'numeroCompte' => Auth::user()->numeroCompte,
        ]);

        return back()->with('success', 'Relevé enregistré !');
    }

    public function ajouterNettoyage(Request $request)
    {
        $validated = $request->validate([
            'commentaire' => 'required|string|max:255'
        ]);
        DB::table('salleEtSecurite')->insert([
            'type' => 1,
            'temperature1' => 0,
            'temperature2' => 0,
            'commentaire' => $validated['commentaire'],
            'nom' => Auth::user()->nom  . ' ' . Auth::user()->prenom,
            'numeroCompte' => Auth::user()->numeroCompte,
        ]);

        return back()->with('success', 'Nettoyage enregistré !');
    }

    
}