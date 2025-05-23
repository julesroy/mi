<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Carte
 *
 * Ce modèle représente un élément de la carte dans la base de données.
 */
class Event extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'idEvent';
    public $timestamps = false;
    protected $fillable = ['nom', 'date', 'prix'];
}
