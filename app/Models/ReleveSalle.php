<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ReleveSalle
 *
 * Ce modèle représente un relevé salle & sécurité
 */
class ReleveSalle extends Model
{
    protected $table = 'salleEtSecurite';
    protected $primaryKey = 'idReleve';
    public $timestamps = false;

    protected $fillable = ['type', 'date', 'temperature1', 'temperature2', 'idUtilisateur', 'commentaire'];

    /**
     * Récupère l'entrée `Utilisateur` liée à ce relevé
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'idUtilisateur');
    }
}
