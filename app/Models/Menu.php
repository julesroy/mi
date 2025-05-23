<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Menu
 *
 * Ce modèle représente un des différents types de menus possibles, stockés dans la base de données.
 */
class Menu extends Model
{
    protected $table = 'carteMenus';
    protected $primaryKey = 'idMenu';
    public $timestamps = false;

    protected $fillable = ['nom', 'elementsMenu', 'prix', 'typeMenu'];
}
