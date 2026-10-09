{{-- resources/views/comptable/classes/show.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Détails de la classe')
@section('page-title', 'Détails de la classe')
@section('page-subtitle', 'Informations complètes de la classe')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="detail-card">
        <div class="detail-header">
            <div class="header-left">
                <div class="classe-avatar-large">
                    {{ strtoupper(substr($classe->nom_classe, 0, 2)) }}
                </div>
                <div>
                    <h2>{{ $classe->nom_classe }}</h2>
                    <div class="classe-meta">
                        <span class="niveau-badge"><i class="fas fa-graduation-cap"></i> {{ $classe->niveau }}</span>
                        <span class="year-badge"><i class="fas fa-calendar-alt"></i> {{ $classe->annee_scolaire }}</span>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <a href="{{ route('comptable.classes.edit', $classe->id_classe) }}" class="btn-primary">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('comptable.classes.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        <div class="detail-body">
            <div class="info-grid">
                <!-- Informations générales -->
                <div class="info-card">
                    <h4><i class="fas fa-info-circle"></i> Informations générales</h4>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-tag"></i> Nom de la classe</span>
                        <span class="info-value">{{ $classe->nom_classe }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-layer-group"></i> Niveau</span>
                        <span class="info-value">{{ $classe->niveau }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-calendar"></i> Année scolaire</span>
                        <span class="info-value">{{ $classe->annee_scolaire }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-align-left"></i> Description</span>
                        <span class="info-value">{{ $classe->description ?? 'Aucune description' }}</span>
                    </div>
                </div>

                <!-- Capacité et effectif -->
                <div class="info-card">
                    <h4><i class="fas fa-users"></i> Capacité et effectif</h4>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-chair"></i> Capacité maximale</span>
                        <span class="info-value">{{ $classe->capacite }} places</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-user-graduate"></i> Effectif actuel</span>
                        <span class="info-value">
                            <strong class="text-primary">{{ $classe->effectif }}</strong> élèves
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-door-open"></i> Places disponibles</span>
                        <span class="info-value">{{ $classe->capacite - $classe->effectif }} places</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-chart-line"></i> Taux de remplissage</span>
                        <span class="info-value">
                            <div class="progress-cell">
                                <div class="progress-bar-cell">
                                    <div class="progress-fill" style="width: {{ $classe->taux_remplissage }}%; background: {{ $classe->taux_remplissage >= 80 ? '#ef4444' : ($classe->taux_remplissage >= 60 ? '#f59e0b' : '#10b981') }}"></div>
                                </div>
                                <span class="progress-percent">{{ $classe->taux_remplissage }}%</span>
                            </div>
                        </span>
                    </div>
                </div>

                <!-- Frais de scolarité -->
                <div class="info-card">
                    <h4><i class="fas fa-money-bill-wave"></i> Frais de scolarité</h4>
                    @forelse($classe->frais as $frais)
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-receipt"></i> {{ $frais->libelle }}</span>
                        <span class="info-value">{{ number_format($frais->montant, 0, ',', ' ') }} FC</span>
                    </div>
                    @empty
                    <div class="empty-message">
                        <i class="fas fa-coins fa-2x"></i>
                        <p>Aucun frais défini pour cette classe</p>
                    </div>
                    @endforelse
                    <div class="info-row mt-2">
                        <a href="{{ route('comptable.frais.create', ['classe_id' => $classe->id_classe]) }}" class="btn-link-sm">
                            <i class="fas fa-plus-circle"></i> Ajouter un frais
                        </a>
                    </div>
                </div>

                <!-- Liste des élèves -->
                <div class="info-card">
                    <h4><i class="fas fa-child"></i> Liste des élèves</h4>
                    @forelse($classe->eleves as $eleve)
                    <div class="info-row">
                        <span class="info-label">
                            <i class="fas fa-user"></i> {{ $eleve->prenom }} {{ $eleve->nom }}
                        </span>
                        <span class="info-value">
                            <span class="matricule-badge">{{ $eleve->matricule ?? 'N/A' }}</span>
                        </span>
                    </div>
                    @empty
                    <div class="empty-message">
                        <i class="fas fa-users-slash fa-2x"></i>
                        <p>Aucun élève inscrit dans cette classe</p>
                    </div>
                    @endforelse
                    <div class="info-row mt-2">
                        <a href="{{ route('comptable.eleves.create', ['classe_id' => $classe->id_classe]) }}" class="btn-link-sm">
                            <i class="fas fa-plus-circle"></i> Ajouter un élève
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    /* ============================================
       DESIGN MODERNE - COMPTABLE
       COINS CARRÉS - COULEURS VERTES/ORANGES
    ============================================ */
    
    :root {
        --primary: #10b981;
        --primary-dark: #059669;
        --primary-light: #34d399;
        --accent: #fbbf24;
        --accent-dark: #f59e0b;
        --danger: #ef4444;
        --warning: #f59e0b;
        --dark: #1e293b;
        --dark-bg: #064e3b;
        --gray: #64748b;
        --gray-light: #f8fafc;
        --white: #ffffff;
        --gradient-primary: linear-gradient(135deg, #064e3b 0%, #047857 100%);
        --gradient-accent: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-glow: 0 0 20px rgba(16, 185, 129, 0.3);
        --transition: all 0.3s ease;
    }

    /* Coins carrés */
    .detail-card, .detail-header, .classe-avatar-large, .btn-primary, 
    .btn-secondary, .niveau-badge, .year-badge, .info-card, 
    .progress-bar-cell, .matricule-badge {
        border-radius: 0px !important;
    }

    .detail-card {
        background: var(--white);
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    /* Header avec dégradé vert */
    .detail-header {
        padding: 1.5rem;
        background: var(--gradient-primary);
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
        background: linear-gradient(90deg, transparent, rgba(251, 191, 36, 0.15));
        pointer-events: none;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        position: relative;
        z-index: 1;
    }

    .classe-avatar-large {
        width: 85px;
        height: 85px;
        background: var(--gradient-accent);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--dark);
        font-size: 1.75rem;
        font-weight: 800;
        box-shadow: 0 0 20px rgba(251, 191, 36, 0.4);
    }

    .detail-header h2 {
        color: var(--white);
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .classe-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.625rem;
    }

    .niveau-badge, .year-badge {
        background: rgba(255, 255, 255, 0.15);
        padding: 0.25rem 0.75rem;
        color: var(--white);
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .niveau-badge i, .year-badge i {
        font-size: 0.688rem;
    }

    /* Boutons */
    .header-right {
        display: flex;
        gap: 0.75rem;
        position: relative;
        z-index: 1;
    }

    .btn-primary {
        background: var(--gradient-accent);
        border: none;
        padding: 0.625rem 1.25rem;
        color: var(--dark);
        font-weight: 700;
        font-size: 0.813rem;
        cursor: pointer;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary:hover {
        background: #f59e0b;
        transform: translateY(-2px);
        box-shadow: 0 0 15px rgba(251, 191, 36, 0.4);
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
        color: var(--accent-dark);
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

    .text-primary {
        color: var(--primary);
        font-weight: 700;
    }

    /* Progression */
    .progress-cell {
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }

    .progress-bar-cell {
        width: 100px;
        background: #e2e8f0;
        height: 6px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        transition: width 0.5s ease;
    }

    .progress-percent {
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Matricule badge */
    .matricule-badge {
        display: inline-block;
        padding: 0.125rem 0.5rem;
        background: #f1f5f9;
        font-size: 0.688rem;
        font-family: monospace;
        color: var(--gray);
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
        
        .classe-meta {
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
        
        .classe-avatar-large {
            width: 65px;
            height: 65px;
            font-size: 1.25rem;
        }
        
        .detail-header h2 {
            font-size: 1.25rem;
        }
        
        .progress-cell {
            flex-wrap: wrap;
        }
    }
</style>
@endpush
@endsection