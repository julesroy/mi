<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriseCommandeInventaire extends Model
{
    protected $table = 'inventaire'; // adapte si ta table a un autre nom
    public $timestamps = false;
    protected $fillable = ['nom', 'quantite']; // adapte selon ta structure
}
