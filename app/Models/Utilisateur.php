<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Utilisateur extends Authenticatable
{
    protected $table = 'utilisateurs';
    protected $primaryKey = 'idUtilisateur';
    public $timestamps = false;

    protected $fillable = ['email', 'mdp'];

    protected $hidden = ['mdp'];

    // nom du champ (dans le formulaire blade)
    public function getAuthPassword()
    {
        return $this->mdp;
    }
}
