<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriseCommandeInventaire extends Model
{
    protected $table = 'inventaire';
    public $timestamps = false;
    protected $fillable = ['nom', 'quantite'];
}
