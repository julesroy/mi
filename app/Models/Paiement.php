<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Représente une commande effectuée par un utilisateur dans la BDD
 */
class Paiement extends Model
{
    protected $table = 'paiements';
    protected $primaryKey = 'idPaiement';
    public $timestamps = false;

    protected $fillable = [
        'idPaiement',
        'montant',
        'type',
        'date',
        'idUtilisateur'
    ];

    /**
     * Récupère les commandes associées à ce paiement
     */
    public function commandes(): HasMany
    {
        return $this->hasMany(Commande::class, 'idPaiement');
    }
}
