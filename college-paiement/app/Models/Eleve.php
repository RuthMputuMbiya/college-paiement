<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Eleve extends Model
{
    use HasFactory;

    protected $table = 'eleves';
    protected $primaryKey = 'id_eleve';

    protected $fillable = [
        'nom',
        'prenom',
        'date_naissance',
        'sexe',
        'email',
        'mot_de_passe',
        'telephone_parent',
        'nom_parent',
        'email_parent',
        'classe_id',
        'parent_id',
        'statut',
        'premiere_connexion',
        'last_login_at',
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'premiere_connexion' => 'boolean',
        'last_login_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ==================== ACCESSORS & MUTATORS ====================

    /**
     * Hasher automatiquement le mot de passe lors de l'assignation
     */
    public function setMotDePasseAttribute($value)
    {
        $this->attributes['mot_de_passe'] = Hash::make($value);
    }

    /**
     * Vérifier si le mot de passe correspond
     */
    public function verifierMotDePasse($password): bool
    {
        return Hash::check($password, $this->mot_de_passe);
    }

    /**
     * Obtenir le nom complet de l'élève
     */
    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }

    /**
     * Obtenir le nom complet avec la classe
     */
    public function getNomCompletAvecClasseAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom . ' (' . ($this->classe->nom_classe ?? 'N/A') . ')';
    }

    /**
     * Obtenir l'âge de l'élève
     */
    public function getAgeAttribute(): int
    {
        return $this->date_naissance->age;
    }

    /**
     * Obtenir le total payé par l'élève
     */
    public function getTotalPayeAttribute(): float
    {
        return $this->paiements()->where('statut', 'valide')->sum('montant');
    }

    /**
     * Obtenir le nombre de paiements effectués
     */
    public function getNbPaiementsAttribute(): int
    {
        return $this->paiements()->where('statut', 'valide')->count();
    }

    /**
     * Obtenir le statut en français
     */
    public function getStatutLabelAttribute(): string
    {
        return match($this->statut) {
            'inscrit'   => 'Inscrit',
            'exclu'     => 'Exclu',
            'transfere' => 'Transféré',
            default     => 'Inconnu',
        };
    }

    /**
     * Obtenir la couleur du statut pour le badge
     */
    public function getStatutColorAttribute(): string
    {
        return match($this->statut) {
            'inscrit'   => 'success',
            'exclu'     => 'danger',
            'transfere' => 'warning',
            default     => 'secondary',
        };
    }

    /**
     * Obtenir le sexe en français
     */
    public function getSexeLabelAttribute(): string
    {
        return $this->sexe === 'M' ? 'Masculin' : 'Féminin';
    }

    /**
     * Vérifier si l'élève est inscrit
     */
    public function estInscrit(): bool
    {
        return $this->statut === 'inscrit';
    }

    /**
     * Vérifier si c'est la première connexion
     */
    public function estPremiereConnexion(): bool
    {
        return $this->premiere_connexion;
    }

    /**
     * Marquer la fin de la première connexion
     */
    public function marquerPremiereConnexionTerminee(): void
    {
        $this->update(['premiere_connexion' => false]);
    }

    /**
     * Mettre à jour la dernière connexion
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    // ==================== RELATIONS ====================

    /**
     * Relation avec la classe
     */
    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classe_id', 'id_classe');
    }

    /**
     * Relation avec le parent (utilisateur)
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * Relation avec les paiements
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'eleve_id', 'id_eleve');
    }

    // ==================== SCOPES ====================

    /**
     * Scope pour les élèves inscrits
     */
    public function scopeInscrits($query)
    {
        return $query->where('statut', 'inscrit');
    }

    /**
     * Scope pour les élèves exclus
     */
    public function scopeExclus($query)
    {
        return $query->where('statut', 'exclu');
    }

    /**
     * Scope pour les élèves transférés
     */
    public function scopeTransferes($query)
    {
        return $query->where('statut', 'transfere');
    }

    /**
     * Scope pour les garçons
     */
    public function scopeGarcons($query)
    {
        return $query->where('sexe', 'M');
    }

    /**
     * Scope pour les filles
     */
    public function scopeFilles($query)
    {
        return $query->where('sexe', 'F');
    }

    /**
     * Scope pour une classe spécifique
     */
    public function scopeParClasse($query, $classeId)
    {
        return $query->where('classe_id', $classeId);
    }

    /**
     * Scope pour un parent spécifique
     */
    public function scopeParParent($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }

    /**
     * Scope pour les élèves actifs (inscrits)
     */
    public function scopeActifs($query)
    {
        return $query->where('statut', 'inscrit');
    }

    // ==================== MÉTHODES STATIQUES ====================

    /**
     * Générer un email unique pour l'élève
     */
    public static function genererEmailUnique($prenom, $nom): string
    {
        $baseEmail = strtolower($prenom . '.' . $nom) . '@college-ndg.cd';
        $email = $baseEmail;
        $compteur = 1;
        
        while (self::where('email', $email)->exists()) {
            $email = strtolower($prenom . '.' . $nom . $compteur) . '@college-ndg.cd';
            $compteur++;
        }
        
        return $email;
    }

    /**
     * Obtenir les statistiques globales
     */
    public static function getStatistiques(): array
    {
        return [
            'total'       => self::count(),
            'inscrits'    => self::where('statut', 'inscrit')->count(),
            'exclus'      => self::where('statut', 'exclu')->count(),
            'transferes'  => self::where('statut', 'transfere')->count(),
            'garcons'     => self::where('sexe', 'M')->count(),
            'filles'      => self::where('sexe', 'F')->count(),
            'moyenne_age' => self::avg('age'),
        ];
    }

    /**
     * Réinitialiser le mot de passe d'un élève
     */
    public static function reinitialiserMotDePasse($email, $newPassword = 'password')
    {
        $eleve = self::where('email', $email)->first();
        if ($eleve) {
            $eleve->mot_de_passe = $newPassword;
            $eleve->premiere_connexion = true;
            $eleve->save();
            return true;
        }
        return false;
    }
}