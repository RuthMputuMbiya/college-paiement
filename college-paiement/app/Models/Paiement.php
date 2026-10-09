<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Paiement extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     */
    protected $table = 'paiements';

    /**
     * La clé primaire.
     */
    protected $primaryKey = 'id_paiement';

    /**
     * Les attributs qui sont mass assignable.
     */
    protected $fillable = [
        'reference',
        'montant',
        'date_paiement',
        'statut',
        'operateur',
        'numero_mobile',
        'code_transaction',
        'reponse_api',
        'eleve_id',
        'frais_id',
        'parent_id',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'montant' => 'decimal:0',
        'date_paiement' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Générer automatiquement une référence unique
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($paiement) {
            if (empty($paiement->reference)) {
                $paiement->reference = 'PAY-' . strtoupper(Str::random(13));
            }
        });
    }

    /**
     * Relation avec l'élève
     */
    public function eleve()
    {
        return $this->belongsTo(Eleve::class, 'eleve_id', 'id_eleve');
    }

    /**
     * Relation avec le frais
     */
    public function frais()
    {
        return $this->belongsTo(Frais::class, 'frais_id', 'id_frais');
    }

    /**
     * Relation avec le parent
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }

    /**
     * Relation avec le litige
     */
    public function litige()
    {
        return $this->hasOne(Litige::class, 'paiement_id', 'id_paiement');
    }

    /**
     * Relation avec le reçu
     */
    public function recu()
    {
        return $this->hasOne(Recu::class, 'paiement_id', 'id_paiement');
    }

    /**
     * Relation avec la simulation
     */
    public function simulation()
    {
        return $this->hasOne(SimulationPaiement::class, 'paiement_id', 'id_paiement');
    }

    /**
     * Vérifier si le paiement est validé
     */
    public function estValide(): bool
    {
        return $this->statut === 'valide';
    }

    /**
     * Vérifier si le paiement est en attente
     */
    public function estEnAttente(): bool
    {
        return $this->statut === 'en_attente';
    }
}