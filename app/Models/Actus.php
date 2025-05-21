<?php

//Actus coté utilisateur

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Actus
 *
 * Ce modèle représente une actualité dans la base de données.
 */
class Actus extends Model
{
    protected $table = 'actus';
    protected $primaryKey = 'idActu';
    public $timestamps = false;
    protected $fillable = ['type', 'titre', 'date', 'image'];
}