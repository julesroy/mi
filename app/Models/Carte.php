<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carte extends Model
{
    protected $table = 'carte';
    protected $primaryKey = 'idElement';
    public $timestamps = false;
    
    protected $fillable = [
        'nom', 
        'typePlat', 
        'ingredientsElements', 
        'prix', 
        'prixServeur',
        'description',
        'ref'
    ];
}
