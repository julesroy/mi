<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    protected $table = 'utilisateurs';
    protected $primaryKey = 'idUtilisateur';
    public $timestamps = false;

    protected $fillable = [
        'email',
        'nom',
        'prenom',
        'numeroCompte',
        'solde',
        'acces',
        'mdp'
    ];

    public function getAuthPassword()
    {
        return $this->mdp;
    }
}
