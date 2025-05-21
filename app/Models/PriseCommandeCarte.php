<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriseCommandeCarte extends Model
{
    protected $table = 'carteElements';
    public $timestamps = false;
    protected $fillable = ['nom', 'prix', 'typePlat'];
}
