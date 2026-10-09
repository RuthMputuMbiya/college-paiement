<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * La table associée au modèle.
     */
    protected $table = 'users';

    /**
     * La clé primaire.
     */
    protected $primaryKey = 'id';

    /**
     * Les attributs qui sont mass assignable.
     */
    protected $fillable = [
        'identifiant_unique',
        'name',
        'email',
        'telephone',
        'adresse',
        'profession',
        'role',        // valeurs: gestionnaire_systeme, comptable, parent
        'statut',      // valeurs: actif, inactif
        'password',
        'email_verified_at',
        'last_login_at',
    ];

    /**
     * Les attributs qui doivent être cachés pour la sérialisation.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ==================== VÉRIFICATIONS DE RÔLE ====================

    /**
     * Vérifier si l'utilisateur est gestionnaire système
     */
    public function isGestionnaireSysteme(): bool
    {
        return $this->role === 'gestionnaire_systeme';
    }

    /**
     * Vérifier si l'utilisateur est administrateur (pour compatibilité)
     */
    public function isAdministrateur(): bool
    {
        return $this->role === 'gestionnaire_systeme';
    }

    /**
     * Vérifier si l'utilisateur est comptable
     */
    public function isComptable(): bool
    {
        return $this->role === 'comptable';
    }

    /**
     * Vérifier si l'utilisateur est parent
     */
    public function isParent(): bool
    {
        return $this->role === 'parent';
    }

    /**
     * Vérifier si le compte est actif
     */
    public function isActive(): bool
    {
        return $this->statut === 'actif';
    }

    // ==================== ACCESSORS ====================

    /**
     * Obtenir le libellé du rôle en français
     */
    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'gestionnaire_systeme' => 'Gestionnaire Système',
            'comptable'           => 'Comptable',
            'parent'              => 'Parent',
            default               => 'Inconnu',
        };
    }

    /**
     * Obtenir la classe CSS pour le badge du rôle
     */
    public function getRoleBadgeClassAttribute(): string
    {
        return match($this->role) {
            'gestionnaire_systeme' => 'role-gestionnaire',
            'comptable'           => 'role-comptable',
            'parent'              => 'role-parent',
            default               => '',
        };
    }

    /**
     * Obtenir la couleur pour le badge du rôle
     */
    public function getRoleColorAttribute(): string
    {
        return match($this->role) {
            'gestionnaire_systeme' => '#4f46e5',
            'comptable'           => '#10b981',
            'parent'              => '#f59e0b',
            default               => '#64748b',
        };
    }

    /**
     * Obtenir l'icône pour le rôle
     */
    public function getRoleIconAttribute(): string
    {
        return match($this->role) {
            'gestionnaire_systeme' => 'fa-user-shield',
            'comptable'           => 'fa-calculator',
            'parent'              => 'fa-users',
            default               => 'fa-user',
        };
    }

    /**
     * Obtenir le nombre d'enfants (pour un parent)
     */
    public function getEnfantsCountAttribute(): int
    {
        return $this->eleves()->count();
    }

    /**
     * Obtenir le total payé (pour un parent)
     */
    public function getTotalPayeAttribute(): float
    {
        return $this->paiements()->where('statut', 'valide')->sum('montant');
    }

    // ==================== RELATIONS ====================

    /**
     * Relation avec les élèves (pour un parent)
     * Un parent peut avoir plusieurs enfants
     */
    public function eleves()
    {
        return $this->hasMany(Eleve::class, 'parent_id', 'id');
    }

    /**
     * Relation avec les paiements effectués (pour un parent)
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'parent_id', 'id');
    }

    /**
     * Relation avec les litiges traités (pour un gestionnaire/comptable)
     */
    public function litigesTraites()
    {
        return $this->hasMany(Litige::class, 'traite_par', 'id');
    }

    /**
     * Relation avec les activités (logs)
     */
    public function activites()
    {
        return $this->hasMany(ActivityLog::class, 'user_id', 'id');
    }

    // ==================== SCOPES ====================

    /**
     * Scope pour les utilisateurs actifs
     */
    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    /**
     * Scope pour les utilisateurs inactifs
     */
    public function scopeInactifs($query)
    {
        return $query->where('statut', 'inactif');
    }

    /**
     * Scope pour les gestionnaires système
     */
    public function scopeGestionnaires($query)
    {
        return $query->where('role', 'gestionnaire_systeme');
    }

    /**
     * Scope pour les comptables
     */
    public function scopeComptables($query)
    {
        return $query->where('role', 'comptable');
    }

    /**
     * Scope pour les parents
     */
    public function scopeParents($query)
    {
        return $query->where('role', 'parent');
    }

    // ==================== MÉTHODES ====================

    /**
     * Vérifier si l'utilisateur a un rôle spécifique
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Vérifier si l'utilisateur a un des rôles spécifiés
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }

    /**
     * Activer le compte utilisateur
     */
    public function activer(): void
    {
        $this->update(['statut' => 'actif']);
    }

    /**
     * Désactiver le compte utilisateur
     */
    public function desactiver(): void
    {
        $this->update(['statut' => 'inactif']);
    }

    /**
     * Mettre à jour la dernière connexion
     */
    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Générer un identifiant unique pour l'utilisateur
     */
    public static function generateIdentifiant(string $role): string
    {
        $prefix = match($role) {
            'gestionnaire_systeme' => 'GS',
            'comptable'           => 'CPT',
            'parent'              => 'PAR',
            default               => 'USR',
        };
        
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -6));
        
        return "{$prefix}-{$date}-{$random}";
    }
}