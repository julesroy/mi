<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Carte
 *
 * Ce modèle représente un élément de la carte dans la base de données.
 */
class Ingredient extends Model
{
    protected $table = 'inventaire';
    protected $primaryKey = 'idIngredient';
    public $timestamps = false;

    protected $fillable = ['nom', 'quantite', 'categorieIngredient', 'commentaire', 'marque', 'estimationPrix'];
}
