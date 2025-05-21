<?php

//Actus coté utilisateur

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actus extends Model
{
    protected $table = 'actus';
    protected $primaryKey = 'idActu';
    public $timestamps = false;
    protected $fillable = ['type', 'titre', 'date', 'image'];
}