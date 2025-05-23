<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Représente une réservation dans le planning des serveurs
 */
class ReservationPlanning extends Model
{
    protected $table = 'planning';
    protected $primaryKey = 'idInscription';
    public $timestamps = false;

    protected $fillable = [
        'idUtilisateur',
        'poste',
        'date'
    ];

    /**
     * Renvoie l'utilisateur inscrit sur cette réservation
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'idUtilisateur');
    }
}
