<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Litige extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     */
    protected $table = 'litiges';

    /**
     * La clé primaire.
     */
    protected $primaryKey = 'id_litige';

    /**
     * Les attributs qui sont mass assignable.
     */
    protected $fillable = [
        'motif',
        'description',
        'date_ouverture',
        'date_resolution',
        'statut',
        'solution',
        'paiement_id',
        'traite_par',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'date_ouverture' => 'date',
        'date_resolution' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec le paiement
     */
    public function paiement()
    {
        return $this->belongsTo(Paiement::class, 'paiement_id', 'id_paiement');
    }

    /**
     * Relation avec l'utilisateur qui a traité
     */
    public function traiteur()
    {
        return $this->belongsTo(User::class, 'traite_par', 'id');
    }

    /**
     * Vérifier si le litige est résolu
     */
    public function estResolu(): bool
    {
        return $this->statut === 'resolu';
    }

    /**
     * Vérifier si le litige est ouvert
     */
    public function estOuvert(): bool
    {
        return $this->statut === 'ouvert';
    }
}