<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actu;

class ActuController extends Controller
{
    public function index(Request $request)
    {
        $query = Actu::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titre', 'like', "%{$search}%")
                  ->orWhere('contenu', 'like', "%{$search}%");
            });
        }

        $actus = $query->orderByDesc('date')->get();

        return view('admin.gestion-actus', compact('actus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);

        Actu::create($validated);

        return redirect()->route('gestion-actus')->with('success', 'Actualité ajoutée avec succès.');
    }

    public function update(Request $request, $id)
    {
        $actu = Actu::findOrFail($id);

        $validated = $request->validate([
            'date' => 'required|date',
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);

        $actu->update($validated);

        return redirect()->route('gestion-actus')->with('success', 'Actualité modifiée avec succès.');
    }

    public function destroy($id)
    {
        $actu = Actu::findOrFail($id);
        $actu->delete();

        return redirect()->route('gestion-actus')->with('success', 'Actualité supprimée.');
    }
}
