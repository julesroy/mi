<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actu extends Model
{
    protected $table = 'actus';
    protected $primaryKey = 'idActu';
    public $timestamps = false;

    protected $fillable = ['date', 'titre', 'contenu'];
}
