<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Représente une commande effectuée par un utilisateur dans la BDD
 */
class Commande extends Model
{
    protected $table = 'commandes';
    protected $primaryKey = 'idCommande';
    public $timestamps = false;

    protected $fillable = [
        'idCommande',
        'numeroCommande',
        'prix',
        'date',
        'etat',
        'stock',
        'menu',
        'commentaire',
        'idUtilisateur',
        'categorieCommande',
        'idPaiement'
    ];

    /**
     * Définit la relation entre le modèle `Commande` et l'entrée `Paiement` associée
     */
    public function paiement(): BelongsTo {
        return $this->belongsTo(Paiement::class, 'idPaiement');
    }

    /**
     * Définit la relation entre le modèle `Commande` et l'entrée `Utilisateur` associée
     */
    public function utilisateur(): BelongsTo {
        return $this->belongsTo(Utilisateur::class, 'idUtilisateur');
    }
}
