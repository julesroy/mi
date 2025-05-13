<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'inventaire';
    protected $primaryKey = 'idIngredient';
    public $timestamps = false;

    protected $fillable = ['nom', 'quantite', 'categorieIngredient', 'commentaire', 'marque', 'estimationPrix'];
}
