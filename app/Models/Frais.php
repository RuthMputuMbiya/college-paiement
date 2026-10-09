<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Frais extends Model
{
    use HasFactory;

    protected $table = 'frais';
    protected $primaryKey = 'id_frais';

    protected $fillable = [
        'libelle',           // ← Ajout du champ libelle
        'description',
        'montant',
        'devise',
        'penalite',
        'date_echeance',
        'periodicite',
        'statut',
        'classe_id',
    ];

    protected $casts = [
        'montant' => 'decimal:0',
        'penalite' => 'decimal:0',
        'date_echeance' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec la classe
     */
    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id', 'id_classe');
    }

    /**
     * Relation avec les paiements
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'frais_id', 'id_frais');
    }

    /**
     * Vérifier si le frais est actif
     */
    public function isActif(): bool
    {
        return $this->statut === 'actif';
    }

    /**
     * Obtenir le montant avec pénalité si échéance dépassée
     */
    public function getMontantAvecPenaliteAttribute(): float
    {
        if ($this->isDepasse()) {
            return $this->montant + $this->penalite;
        }
        return $this->montant;
    }

    /**
     * Vérifier si la date d'échéance est dépassée
     */
    public function isDepasse(): bool
    {
        if (is_null($this->date_echeance)) {
            return false;
        }
        
        try {
            return now()->gt(Carbon::parse($this->date_echeance));
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Obtenir le symbole de la devise
     */
    public function getDeviseSymboleAttribute(): string
    {
        return $this->devise === 'FC' ? 'FC' : '$';
    }

    /**
     * Obtenir la date d'échéance formatée
     */
    public function getDateEcheanceFormateeAttribute(): string
    {
        if (is_null($this->date_echeance)) {
            return 'Non définie';
        }
        return Carbon::parse($this->date_echeance)->format('d/m/Y');
    }

    /**
     * Vérifier si la date d'échéance est définie
     */
    public function hasEcheance(): bool
    {
        return !is_null($this->date_echeance);
    }

    /**
     * Obtenir le statut en français
     */
    public function getStatutLabelAttribute(): string
    {
        return $this->statut === 'actif' ? 'Actif' : 'Inactif';
    }

    /**
     * Obtenir la périodicité en français
     */
    public function getPeriodiciteLabelAttribute(): string
    {
        return match($this->periodicite) {
            'mensuel' => 'Mensuel',
            'trimestriel' => 'Trimestriel',
            'semestriel' => 'Semestriel',
            'annuel' => 'Annuel',
            default => 'Non définie',
        };
    }
}