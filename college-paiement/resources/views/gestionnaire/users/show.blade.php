{{-- resources/views/gestionnaire/users/show.blade.php --}}
@extends('layouts.gestionnaire')

@section('title', 'Détails utilisateur')
@section('page-title', 'Fiche utilisateur')
@section('page-subtitle', 'Informations complètes du compte')

@section('content')
<div class="user-detail-container">

    <!-- En-tête avec avatar -->
    <div class="detail-header">
        <div class="header-left">
            <div class="user-avatar-large" style="background: {{ $user->role == 'gestionnaire' ? '#4f46e5' : ($user->role == 'comptable' ? '#10b981' : '#f59e0b') }}">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2>{{ $user->name }}</h2>
                <div class="user-meta">
                    <span class="meta-badge"><i class="fas fa-id-card"></i> {{ $user->identifiant_unique ?? 'N/A' }}</span>
                    <span class="role-badge role-{{ $user->role }}">
                        <i class="fas {{ $user->role == 'gestionnaire' ? 'fa-user-shield' : ($user->role == 'comptable' ? 'fa-calculator' : 'fa-users') }}"></i>
                        {{ ucfirst($user->role) }}
                    </span>
                    <span class="status-badge status-{{ $user->statut }}">
                        <i class="fas {{ $user->statut == 'actif' ? 'fa-check-circle' : 'fa-ban' }}"></i>
                        {{ $user->statut == 'actif' ? 'Compte actif' : 'Compte inactif' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="header-right">
            <a href="{{ route('gestionnaire.users.edit', $user->id) }}" class="btn-primary">
                <i class="fas fa-edit"></i> Modifier
            </a>
            <a href="{{ route('gestionnaire.users.index') }}" class="btn-outline">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>
    </div>

    <!-- Grille d'informations -->
    <div class="info-grid">
        <!-- Informations personnelles -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-user-circle"></i>
                <h4>Informations personnelles</h4>
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-user"></i> Nom complet</span>
                    <span class="info-value">{{ $user->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-envelope"></i> Email</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-phone"></i> Téléphone</span>
                    <span class="info-value">{{ $user->telephone ?? 'Non renseigné' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-map-marker-alt"></i> Adresse</span>
                    <span class="info-value">{{ $user->adresse ?? 'Non renseignée' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-briefcase"></i> Profession</span>
                    <span class="info-value">{{ $user->profession ?? 'Non renseignée' }}</span>
                </div>
            </div>
        </div>

        <!-- Informations du compte -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-chart-line"></i>
                <h4>Informations du compte</h4>
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-id-card"></i> ID utilisateur</span>
                    <span class="info-value">{{ $user->id }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-qrcode"></i> Identifiant unique</span>
                    <span class="info-value">{{ $user->identifiant_unique ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-tag"></i> Rôle</span>
                    <span class="info-value">
                        <span class="role-badge role-{{ $user->role }}">
                            <i class="fas {{ $user->role == 'gestionnaire' ? 'fa-user-shield' : ($user->role == 'comptable' ? 'fa-calculator' : 'fa-users') }}"></i>
                            {{ ucfirst($user->role) }}
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-circle"></i> Statut</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $user->statut }}">
                            <i class="fas {{ $user->statut == 'actif' ? 'fa-check-circle' : 'fa-ban' }}"></i>
                            {{ $user->statut == 'actif' ? 'Actif' : 'Inactif' }}
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Dates importantes -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-calendar-alt"></i>
                <h4>Dates importantes</h4>
            </div>
            <div class="info-card-body">
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-calendar-plus"></i> Date de création</span>
                    <span class="info-value">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-edit"></i> Dernière modification</span>
                    <span class="info-value">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-sign-in-alt"></i> Dernière connexion</span>
                    <span class="info-value">
                        @if($user->last_login_at)
                            {{ $user->last_login_at->format('d/m/Y H:i') }}
                        @else
                            <span class="text-muted">Jamais connecté</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label"><i class="fas fa-envelope"></i> Email vérifié</span>
                    <span class="info-value">
                        @if($user->email_verified_at)
                            <span class="text-success"><i class="fas fa-check-circle"></i> Oui ({{ $user->email_verified_at->format('d/m/Y') }})</span>
                        @else
                            <span class="text-muted"><i class="fas fa-times-circle"></i> Non</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-chart-simple"></i>
                <h4>Statistiques</h4>
            </div>
            <div class="info-card-body">
                @if($user->role == 'parent')
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-child"></i> Enfants liés</span>
                        <span class="info-value">{{ $user->eleves->count() }} élève(s)</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-receipt"></i> Paiements effectués</span>
                        <span class="info-value">{{ $user->paiements->count() }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-money-bill-wave"></i> Montant total payé</span>
                        <span class="info-value">{{ number_format($user->paiements->where('statut', 'valide')->sum('montant'), 0, ',', ' ') }} FC</span>
                    </div>
                @else
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-clock"></i> Activités enregistrées</span>
                        <span class="info-value">{{ $user->logs->count() }} actions</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-calendar-week"></i> Dernière activité</span>
                        <span class="info-value">{{ $user->logs->first() ? $user->logs->first()->created_at->diffForHumans() : 'Aucune' }}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
/* ============================================
   DÉTAILS UTILISATEUR - DESIGN MODERNE
   COINS CARRÉS - COULEURS PROFESSIONNELLES
   ============================================ */

:root {
    --primary: #4f46e5;
    --primary-dark: #4338ca;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #3b82f6;
    --dark: #1e293b;
    --gray: #64748b;
    --gray-light: #f8fafc;
    --white: #ffffff;
    --border: #e2e8f0;
}

.user-detail-container {
    max-width: 1400px;
    margin: 0 auto;
}

/* Coins carrés */
.detail-header, .user-avatar-large, .meta-badge, .role-badge,
.status-badge, .info-card, .info-card-header, .btn-primary, .btn-outline {
    border-radius: 0px !important;
}

/* ==========================================
   EN-TÊTE
   ========================================== */
.detail-header {
    background: linear-gradient(135deg, #1e293b 0%, #4f46e5 100%);
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.user-avatar-large {
    width: 85px;
    height: 85px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--white);
}

.detail-header h2 {
    color: var(--white);
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
}

.user-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.625rem;
    align-items: center;
}

.meta-badge {
    background: rgba(255,255,255,0.15);
    padding: 0.25rem 0.75rem;
    color: var(--white);
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
}

.meta-badge i {
    font-size: 0.688rem;
}

/* Role badges dans header */
.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.role-gestionnaire {
    background: rgba(99, 102, 241, 0.2);
    color: #a78bfa;
}

.role-comptable {
    background: rgba(16, 185, 129, 0.2);
    color: #34d399;
}

.role-parent {
    background: rgba(245, 158, 11, 0.2);
    color: #fbbf24;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-actif {
    background: rgba(16, 185, 129, 0.2);
    color: #34d399;
}

.status-inactif {
    background: rgba(239, 68, 68, 0.2);
    color: #fca5a5;
}

/* Boutons */
.header-right {
    display: flex;
    gap: 0.75rem;
}

.btn-primary {
    background: var(--primary);
    color: var(--white);
    padding: 0.5rem 1.25rem;
    text-decoration: none;
    font-size: 0.813rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

.btn-outline {
    background: rgba(255,255,255,0.15);
    padding: 0.5rem 1.25rem;
    color: var(--white);
    text-decoration: none;
    font-size: 0.813rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-outline:hover {
    background: rgba(255,255,255,0.25);
    transform: translateY(-2px);
}

/* ==========================================
   GRILLE D'INFORMATIONS
   ========================================== */
.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}

.info-card {
    background: var(--white);
    border: 1px solid var(--border);
    overflow: hidden;
    transition: all 0.3s ease;
}

.info-card:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.info-card-header {
    padding: 0.875rem 1.25rem;
    background: var(--gray-light);
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-card-header i {
    color: var(--primary);
    font-size: 1rem;
}

.info-card-header h4 {
    font-size: 0.875rem;
    font-weight: 600;
    margin: 0;
    color: var(--dark);
}

.info-card-body {
    padding: 1rem 1.25rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.625rem 0;
    border-bottom: 1px solid var(--border);
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 0.813rem;
    color: var(--gray);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-label i {
    color: var(--primary);
    font-size: 0.75rem;
    width: 1rem;
}

.info-value {
    font-size: 0.813rem;
    font-weight: 500;
    color: var(--dark);
}

.text-muted {
    color: var(--gray);
    font-style: italic;
}

.text-success {
    color: var(--success);
}

/* ==========================================
   RESPONSIVE
   ========================================== */
@media (max-width: 992px) {
    .info-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .detail-header {
        flex-direction: column;
        text-align: center;
    }
    
    .header-left {
        flex-direction: column;
        text-align: center;
    }
    
    .user-meta {
        justify-content: center;
    }
    
    .info-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
}

@media (max-width: 480px) {
    .user-avatar-large {
        width: 65px;
        height: 65px;
        font-size: 1.75rem;
    }
    
    .detail-header h2 {
        font-size: 1.25rem;
    }
    
    .header-right {
        justify-content: center;
    }
    
    .info-card-header, .info-card-body {
        padding: 0.875rem;
    }
}
</style>
@endpush
@endsection