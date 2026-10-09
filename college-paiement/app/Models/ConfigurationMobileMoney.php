<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigurationMobileMoney extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     */
    protected $table = 'configurations_mobile_money';

    /**
     * La clé primaire.
     */
    protected $primaryKey = 'id_config';

    /**
     * Les attributs qui sont mass assignable.
     */
    protected $fillable = [
        'operateur',
        'nom_api',
        'url_simulation',
        'statut',
        'parametres',
        'delai_simulation_ms',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'parametres' => 'array',
        'delai_simulation_ms' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Vérifier si la configuration est active
     */
    public function estActive(): bool
    {
        return $this->statut === 'actif';
    }

    /**
     * Obtenir le taux de succès simulé
     */
    public function getTauxSuccesAttribute(): int
    {
        return $this->parametres['taux_succes'] ?? 95;
    }

    /**
     * Obtenir le code de succès
     */
    public function getCodeSuccesAttribute(): string
    {
        return $this->parametres['code_succes'] ?? '00';
    }
}