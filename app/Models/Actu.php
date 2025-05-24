<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Actu
 *
 * Ce modèle représente une actualité dans la base de données.
 */
class Actu extends Model
{
    protected $table = 'actus';
    protected $primaryKey = 'idActu';
    public $timestamps = false;
    protected $fillable = ['date', 'titre', 'contenu', 'image'];
}
