<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeUtilisateurController extends Controller
{
    public function index()
    {
        $plats = DB::table('carte')->where('typePlat', 0)->get();
        $menus = DB::table('carte')->where('typePlat', 3)->get();
        $viandes = DB::table('inventaire')->where('categorieIngredient', 1)->get();
        $ingredients = DB::table('inventaire')->where('categorieIngredient', 0)->get();
        $snacks = DB::table('carte')->where('typePlat', 1)->get();
        $boissons = DB::table('carte')->where('typePlat', 2)->get();

        return view('commander', compact('plats', 'menus', 'viandes', 'ingredients', 'snacks', 'boissons'));
    }
}
