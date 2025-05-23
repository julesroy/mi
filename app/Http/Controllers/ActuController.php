<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actu;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\Event;

/**
 * ActuController
 *
 * Ce contrôleur gère les opérations CRUD pour les actualités.
 */
class ActuController extends Controller
{
    /**
     * Affiche la page de gestion des actualités.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Actu::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")->orWhere('contenu', 'like', "%{$search}%");
            });
        }

        $actus = $query->orderByDesc('date')->get();

        return view('admin.gestion-actus', compact('actus'));
    }

    /**
     * Affiche la page des actualités et événements.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        $user = Auth::user();

        $now = Carbon::today();

        // Actus à venir ou aujourd'hui
        $actusAvenir = Actu::whereDate('date', '>=', $now)
            ->orderBy('date', 'asc')
            ->get();

        // Actus passées
        $actusPassees = Actu::whereDate('date', '<', $now)
            ->orderBy('date', 'desc')
            ->get();

        // Events à venir ou aujourd'hui
        $eventsAvenir = Event::whereDate('date', '>=', $now)
            ->orderBy('date', 'asc')
            ->get();

        return view('actus', [
            'user'          => $user,
            'actusAvenir'   => $actusAvenir,
            'actusPassees'  => $actusPassees,
            'eventsAvenir'  => $eventsAvenir,
        ]);
    }

    /**
     * Stocke une nouvelle actualité dans la base de données.
     *
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|image|max:2048', // max 2Mo
        ]);

        // On crée l'actu sans image d'abord pour avoir l'id
        $actu = Actu::create([
            'date' => $validated['date'],
            'titre' => $validated['titre'],
            'contenu' => $validated['contenu'],
            'image' => null,
        ]);

        // Gestion de l'image
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $ext = $request->file('image')->extension();
            $filename = $actu->idActu . '.' . $ext;
            $path = $request->file('image')->storeAs('actus', $filename, 'public');
            $actu->image = $path; // ex: actus/17.jpg
            $actu->save();
        }

        return redirect()->route('gestion-actus')->with('success', 'Actualité ajoutée avec succès.');
    }

    /**
     * Met à jour une actualité dans la base de données.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function update(Request $request, $id)
    {
        $actu = Actu::findOrFail($id);

        $validated = $request->validate([
            'date' => 'required|date',
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'delete_image' => 'nullable|boolean',
        ]);

        $actu->update([
            'date' => $validated['date'],
            'titre' => $validated['titre'],
            'contenu' => $validated['contenu'],
        ]);

        // Suppression de l'image si demandé
        if ($request->has('delete_image') && $request->delete_image) {
            if ($actu->image && Storage::disk('public')->exists($actu->image)) {
                Storage::disk('public')->delete($actu->image);
            }
            $actu->image = null;
            $actu->save();
        }

        // Upload d'une nouvelle image si présente
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Supprime l'ancienne image si elle existe
            if ($actu->image && Storage::disk('public')->exists($actu->image)) {
                Storage::disk('public')->delete($actu->image);
            }
            $ext = $request->file('image')->extension();
            $filename = $actu->idActu . '.' . $ext;
            $path = $request->file('image')->storeAs('actus', $filename, 'public');
            $actu->image = $path;
            $actu->save();
        }

        return redirect()->route('gestion-actus')->with('success', 'Actualité modifiée avec succès.');
    }

    /**
     * Supprime une actualité de la base de données.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function destroy($id)
    {
        $actu = Actu::findOrFail($id);

        if ($actu->image && Storage::disk('public')->exists($actu->image)) {
            Storage::disk('public')->delete($actu->image);
        }

        $actu->delete();

        return redirect()->route('gestion-actus')->with('success', 'Actualité supprimée.');
    }
}
