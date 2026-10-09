{{-- resources/views/comptable/parents/show.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Détails du parent')
@section('page-title', 'Fiche parent')
@section('page-subtitle', 'Informations complètes du parent')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="detail-card">
        <div class="detail-header">
            <div class="header-left">
                <div class="parent-avatar-large">
                    {{ strtoupper(substr($parent->name, 0, 1)) }}
                </div>
                <div>
                    <h2>{{ $parent->name }}</h2>
                    <div class="parent-meta">
                        <span class="id-badge"><i class="fas fa-id-card"></i> {{ $parent->identifiant_unique ?? 'N/A' }}</span>
                        <span class="status-badge status-{{ $parent->statut }}">
                            <i class="fas {{ $parent->statut == 'actif' ? 'fa-check-circle' : 'fa-ban' }}"></i>
                            {{ $parent->statut == 'actif' ? 'Compte actif' : 'Compte inactif' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <a href="{{ route('comptable.parents.edit', $parent->id) }}" class="btn-primary">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('comptable.parents.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        <div class="detail-body">
            <div class="info-grid">
                <!-- Informations personnelles -->
                <div class="info-card">
                    <h4><i class="fas fa-user-circle"></i> Informations personnelles</h4>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-user"></i> Nom complet</span>
                        <span class="info-value">{{ $parent->name }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-envelope"></i> Email</span>
                        <span class="info-value">{{ $parent->email }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-phone"></i> Téléphone</span>
                        <span class="info-value">{{ $parent->telephone ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-map-marker-alt"></i> Adresse</span>
                        <span class="info-value">{{ $parent->adresse ?? 'Non renseignée' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-briefcase"></i> Profession</span>
                        <span class="info-value">{{ $parent->profession ?? 'Non renseignée' }}</span>
                    </div>
                </div>

                <!-- Statistiques -->
                <div class="info-card">
                    <h4><i class="fas fa-chart-line"></i> Statistiques</h4>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-calendar-plus"></i> Date d'inscription</span>
                        <span class="info-value">{{ $parent->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-clock"></i> Dernière connexion</span>
                        <span class="info-value">{{ $parent->last_login_at ? $parent->last_login_at->format('d/m/Y H:i') : 'Jamais' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-money-bill-wave"></i> Total payé</span>
                        <span class="info-value stat-highlight">{{ number_format($totalPaye ?? 0, 0, ',', ' ') }} FC</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-receipt"></i> Nombre de paiements</span>
                        <span class="info-value">{{ $nbPaiements ?? 0 }}</span>
                    </div>
                </div>

                <!-- Enfants -->
                <div class="info-card">
                    <h4><i class="fas fa-child"></i> Enfants inscrits</h4>
                    @forelse($parent->eleves as $eleve)
                    <div class="info-row">
                        <span class="info-label">
                            <i class="fas fa-graduation-cap"></i> {{ $eleve->prenom }} {{ $eleve->nom }}
                        </span>
                        <span class="info-value">
                            {{ $eleve->classe->nom_classe ?? 'N/A' }}
                            <span class="student-status status-{{ $eleve->statut }}">
                                {{ $eleve->statut }}
                            </span>
                        </span>
                    </div>
                    @empty
                    <div class="empty-message">
                        <i class="fas fa-child fa-2x"></i>
                        <p>Aucun enfant lié à ce parent</p>
                    </div>
                    @endforelse
                    <div class="info-row mt-2">
                        <a href="{{ route('comptable.eleves.create', ['parent_id' => $parent->id]) }}" class="btn-link-sm">
                            <i class="fas fa-plus-circle"></i> Ajouter un enfant
                        </a>
                    </div>
                </div>

                <!-- Derniers paiements -->
                <div class="info-card">
                    <h4><i class="fas fa-receipt"></i> Derniers paiements</h4>
                    @forelse($parent->paiements->take(5) as $paiement)
                    <div class="info-row">
                        <span class="info-label">
                            <i class="fas fa-hashtag"></i> {{ $paiement->reference }}
                        </span>
                        <span class="info-value payment-amount">{{ number_format($paiement->montant, 0, ',', ' ') }} FC</span>
                    </div>
                    @empty
                    <div class="empty-message">
                        <i class="fas fa-receipt fa-2x"></i>
                        <p>Aucun paiement effectué</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    /* ============================================
       DESIGN MODERNE - COMPTABLE
       COINS CARRÉS - COULEURS VERTES
    ============================================ */
    
    :root {
        --primary: #10b981;
        --primary-dark: #059669;
        --primary-light: #34d399;
        --secondary: #06b6d4;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #1e293b;
        --dark-bg: #0f172a;
        --gray: #64748b;
        --gray-light: #f8fafc;
        --white: #ffffff;
        --gradient-primary: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        --gradient-dark: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-glow: 0 0 20px rgba(16, 185, 129, 0.3);
        --transition: all 0.3s ease;
    }

    /* Coins carrés */
    .detail-card, .detail-header, .parent-avatar-large, .btn-primary, 
    .btn-secondary, .id-badge, .status-badge, .info-card, .student-status {
        border-radius: 0px !important;
    }

    .detail-card {
        background: var(--white);
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    /* Header avec dégradé */
    .detail-header {
        padding: 1.5rem;
        background: var(--gradient-dark);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.25rem;
        position: relative;
        overflow: hidden;
    }

    .detail-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.1));
        pointer-events: none;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        position: relative;
        z-index: 1;
    }

    .parent-avatar-large {
        width: 85px;
        height: 85px;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: 2.25rem;
        font-weight: 700;
        box-shadow: var(--shadow-glow);
    }

    .detail-header h2 {
        color: var(--white);
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .parent-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.625rem;
        align-items: center;
    }

    .id-badge {
        background: rgba(255, 255, 255, 0.15);
        padding: 0.25rem 0.75rem;
        color: var(--white);
        font-size: 0.75rem;
        font-family: monospace;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .id-badge i {
        font-size: 0.75rem;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.75rem;
        font-size: 0.688rem;
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
        position: relative;
        z-index: 1;
    }

    .btn-primary {
        background: var(--gradient-primary);
        border: none;
        padding: 0.625rem 1.25rem;
        color: var(--white);
        font-weight: 600;
        font-size: 0.813rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-glow);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.15);
        border: none;
        padding: 0.625rem 1.25rem;
        color: var(--white);
        font-size: 0.813rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: var(--transition);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
    }

    /* Body */
    .detail-body {
        padding: 1.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(360px, 1fr));
        gap: 1.5rem;
    }

    /* Cartes d'information */
    .info-card {
        border: 1px solid #e2e8f0;
        padding: 1.25rem;
        background: var(--white);
        transition: var(--transition);
    }

    .info-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-2px);
    }

    .info-card h4 {
        font-size: 1rem;
        font-weight: 700;
        margin: 0 0 1rem 0;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #e2e8f0;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-card h4 i {
        color: var(--primary);
        font-size: 1.125rem;
    }

    /* Lignes d'information */
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
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

    .stat-highlight {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary);
    }

    .payment-amount {
        font-weight: 600;
        color: var(--dark);
    }

    /* Statut étudiant */
    .student-status {
        display: inline-block;
        padding: 0.125rem 0.5rem;
        font-size: 0.625rem;
        font-weight: 500;
        margin-left: 0.5rem;
    }

    .status-inscrit {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .status-exclu {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    .status-transfere {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    /* Message vide */
    .empty-message {
        text-align: center;
        padding: 1.5rem;
        color: #94a3b8;
        font-size: 0.813rem;
    }

    .empty-message i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        opacity: 0.5;
    }

    .empty-message p {
        margin: 0;
    }

    /* Lien ajout */
    .btn-link-sm {
        color: var(--primary);
        text-decoration: none;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        transition: var(--transition);
    }

    .btn-link-sm:hover {
        color: var(--primary-dark);
        text-decoration: underline;
        transform: translateX(3px);
    }

    .mt-2 {
        margin-top: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .detail-header {
            flex-direction: column;
            text-align: center;
        }
        
        .header-left {
            flex-direction: column;
            text-align: center;
        }
        
        .parent-meta {
            justify-content: center;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .header-right {
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .detail-header {
            padding: 1rem;
        }
        
        .detail-body {
            padding: 1rem;
        }
        
        .info-card {
            padding: 1rem;
        }
        
        .info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        
        .parent-avatar-large {
            width: 65px;
            height: 65px;
            font-size: 1.75rem;
        }
        
        .detail-header h2 {
            font-size: 1.25rem;
        }
    }
</style>
@endpush
@endsection