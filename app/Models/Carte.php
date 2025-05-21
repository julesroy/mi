<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Carte
 *
 * Ce modèle représente un élément de la carte dans la base de données.
 */
class Carte extends Model
{
    protected $table = 'carte';
    protected $primaryKey = 'idElement';
    public $timestamps = false;

    protected $fillable = ['nom', 'typePlat', 'ingredientsElements', 'prix', 'prixServeur', 'description', 'ref'];
}
