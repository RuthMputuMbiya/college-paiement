<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimulationPaiement extends Model
{
    use HasFactory;

    /**
     * La table associée au modèle.
     */
    protected $table = 'simulations_paiement';

    /**
     * La clé primaire.
     */
    protected $primaryKey = 'id_simulation';

    /**
     * Le type de la clé primaire.
     */
    protected $keyType = 'int';

    /**
     * Indique si l'ID est auto-incrémenté.
     */
    public $incrementing = true;

    /**
     * Les attributs qui sont mass assignable.
     */
    protected $fillable = [
        'requete',
        'reponse',
        'statut',
        'temps_reponse_ms',
        'paiement_id',
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     */
    protected $hidden = [
        'requete',
        'reponse',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'requete'          => 'array',        // Convertit automatiquement JSON → array
        'reponse'          => 'array',        // Convertit automatiquement JSON → array
        'temps_reponse_ms' => 'integer',
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
    ];

    /**
     * Les valeurs par défaut des attributs.
     */
    protected $attributes = [
        'statut' => 'pending',
    ];

    // ==================== RELATIONS ====================

    /**
     * Relation inverse avec le paiement
     * Une simulation appartient à un seul paiement
     */
    public function paiement()
    {
        return $this->belongsTo(Paiement::class, 'paiement_id', 'id_paiement');
    }

    /**
     * Récupérer l'élève via le paiement
     */
    public function eleve()
    {
        return $this->hasOneThrough(
            Eleve::class,
            Paiement::class,
            'id_paiement',   // Clé étrangère sur paiements
            'id_eleve',      // Clé étrangère sur eleves
            'paiement_id',   // Clé locale sur simulations_paiement
            'eleve_id'       // Clé locale sur paiements
        );
    }

    // ==================== ACCESSORS ====================

    /**
     * Obtenir le message de la réponse
     */
    public function getMessageReponseAttribute(): ?string
    {
        return $this->reponse['message'] ?? $this->reponse['error'] ?? null;
    }

    /**
     * Obtenir le code de la réponse
     */
    public function getCodeReponseAttribute(): ?string
    {
        return $this->reponse['code'] ?? $this->reponse['status'] ?? null;
    }

    /**
     * Obtenir le temps de réponse en secondes
     */
    public function getTempsReponseSecondesAttribute(): float
    {
        return round($this->temps_reponse_ms / 1000, 2);
    }

    /**
     * Obtenir le résumé de la simulation
     */
    public function getResumeAttribute(): array
    {
        return [
            'statut'        => $this->statut,
            'temps_ms'      => $this->temps_reponse_ms,
            'temps_sec'     => $this->temps_reponse_secondes,
            'message'       => $this->message_reponse,
            'code'          => $this->code_reponse,
            'operateur'     => $this->paiement?->operateur,
            'montant'       => $this->paiement?->montant,
            'reference'     => $this->paiement?->reference,
        ];
    }

    // ==================== MUTATORS ====================

    /**
     * Définir la requête avec timestamp automatique
     */
    public function setRequeteAttribute($value)
    {
        $requeteWithTimestamp = is_array($value) 
            ? array_merge($value, ['timestamp' => now()->toIso8601String()])
            : ['data' => $value, 'timestamp' => now()->toIso8601String()];
        
        $this->attributes['requete'] = json_encode($requeteWithTimestamp);
    }

    /**
     * Définir la réponse avec timestamp automatique
     */
    public function setReponseAttribute($value)
    {
        $reponseWithTimestamp = is_array($value)
            ? array_merge($value, ['timestamp_reception' => now()->toIso8601String()])
            : ['data' => $value, 'timestamp_reception' => now()->toIso8601String()];
        
        $this->attributes['reponse'] = json_encode($reponseWithTimestamp);
    }

    // ==================== VÉRIFICATIONS (BOOLEENS) ====================

    /**
     * Vérifier si la simulation a réussi
     */
    public function estReussie(): bool
    {
        return $this->statut === 'success';
    }

    /**
     * Vérifier si la simulation a échoué
     */
    public function estEchouee(): bool
    {
        return $this->statut === 'failed';
    }

    /**
     * Vérifier si la simulation est en attente
     */
    public function estEnAttente(): bool
    {
        return $this->statut === 'pending';
    }

    /**
     * Vérifier si le temps de réponse est rapide (< 2 secondes)
     */
    public function estRapide(): bool
    {
        return $this->temps_reponse_ms < 2000;
    }

    /**
     * Vérifier si le temps de réponse est lent (> 3 secondes)
     */
    public function estLent(): bool
    {
        return $this->temps_reponse_ms > 3000;
    }

    // ==================== MÉTHODES STATIQUES ====================

    /**
     * Créer une simulation de succès
     */
    public static function creerSucces(int $paiementId, array $requete, array $reponse, int $tempsMs): self
    {
        return self::create([
            'paiement_id'      => $paiementId,
            'requete'          => $requete,
            'reponse'          => $reponse,
            'statut'           => 'success',
            'temps_reponse_ms' => $tempsMs,
        ]);
    }

    /**
     * Créer une simulation d'échec
     */
    public static function creerEchec(int $paiementId, array $requete, array $reponse, int $tempsMs): self
    {
        return self::create([
            'paiement_id'      => $paiementId,
            'requete'          => $requete,
            'reponse'          => $reponse,
            'statut'           => 'failed',
            'temps_reponse_ms' => $tempsMs,
        ]);
    }

    /**
     * Créer une simulation en attente
     */
    public static function creerEnAttente(int $paiementId, array $requete): self
    {
        return self::create([
            'paiement_id'      => $paiementId,
            'requete'          => $requete,
            'reponse'          => ['message' => 'Traitement en cours...'],
            'statut'           => 'pending',
            'temps_reponse_ms' => null,
        ]);
    }

    // ==================== MÉTHODES STATISTIQUES ====================

    /**
     * Obtenir le taux de succès des simulations
     */
    public static function tauxSucces(): float
    {
        $total = self::count();
        if ($total === 0) return 0;
        
        $succes = self::where('statut', 'success')->count();
        return round(($succes / $total) * 100, 2);
    }

    /**
     * Obtenir le temps de réponse moyen
     */
    public static function tempsReponseMoyen(): float
    {
        return round(self::whereNotNull('temps_reponse_ms')->avg('temps_reponse_ms'), 2);
    }

    /**
     * Obtenir les statistiques globales
     */
    public static function statistiques(): array
    {
        return [
            'total'           => self::count(),
            'succes'          => self::where('statut', 'success')->count(),
            'echecs'          => self::where('statut', 'failed')->count(),
            'en_attente'      => self::where('statut', 'pending')->count(),
            'taux_succes'     => self::tauxSucces(),
            'temps_moyen_ms'  => self::tempsReponseMoyen(),
            'temps_min_ms'    => self::whereNotNull('temps_reponse_ms')->min('temps_reponse_ms'),
            'temps_max_ms'    => self::whereNotNull('temps_reponse_ms')->max('temps_reponse_ms'),
        ];
    }

    // ==================== SCOPES ====================

    /**
     * Scope pour les simulations réussies
     */
    public function scopeReussies($query)
    {
        return $query->where('statut', 'success');
    }

    /**
     * Scope pour les simulations échouées
     */
    public function scopeEchouees($query)
    {
        return $query->where('statut', 'failed');
    }

    /**
     * Scope pour les simulations en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'pending');
    }

    /**
     * Scope pour les simulations rapides
     */
    public function scopeRapides($query)
    {
        return $query->where('temps_reponse_ms', '<', 2000);
    }

    /**
     * Scope pour les simulations lentes
     */
    public function scopeLentes($query)
    {
        return $query->where('temps_reponse_ms', '>', 3000);
    }

    /**
     * Scope pour un opérateur spécifique (via la relation paiement)
     */
    public function scopePourOperateur($query, string $operateur)
    {
        return $query->whereHas('paiement', function ($q) use ($operateur) {
            $q->where('operateur', $operateur);
        });
    }
}