<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     */
    protected $table = 'classes';

    /**
     * La clé primaire.
     */
    protected $primaryKey = 'id_classe';

    /**
     * Les attributs qui sont mass assignable.
     */
    protected $fillable = [
        'nom_classe',
        'niveau',
        'annee_scolaire',
        'capacite',
        'effectif',
        'description',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'capacite' => 'integer',
        'effectif' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relation avec les élèves
     */
    public function eleves()
    {
        return $this->hasMany(Eleve::class, 'classe_id', 'id_classe');
    }

    /**
     * Relation avec les frais
     */
    public function frais()
    {
        return $this->hasMany(Frais::class, 'classe_id', 'id_classe');
    }

    /**
     * Vérifier si la classe a de la place
     */
    public function hasPlace(): bool
    {
        return $this->effectif < $this->capacite;
    }

    /**
     * Incrémenter l'effectif
     */
    public function incrementerEffectif()
    {
        $this->increment('effectif');
    }

    /**
     * Décrémenter l'effectif
     */
    public function decrementerEffectif()
    {
        $this->decrement('effectif');
    }

    /**
     * Obtenir le taux de remplissage
     */
    public function getTauxRemplissageAttribute(): float
    {
        if ($this->capacite <= 0) return 0;
        return round(($this->effectif / $this->capacite) * 100, 2);
    }
}