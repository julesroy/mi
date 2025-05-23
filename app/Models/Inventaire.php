<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    protected $table = 'inventaire';
    public $timestamps = false;
    protected $fillable = ['nom', 'quantite'];
}
