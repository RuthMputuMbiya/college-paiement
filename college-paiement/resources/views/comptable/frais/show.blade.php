{{-- resources/views/comptable/frais/show.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Détails du frais')
@section('page-title', 'Détails du frais scolaire')
@section('page-subtitle', 'Informations complètes du frais')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="detail-card">
        <div class="detail-header">
            <div class="header-left">
                <div class="frais-avatar-large">
                    <i class="fas fa-receipt"></i>
                </div>
                <div>
                    <h2>{{ $frais->libelle }}</h2>
                    <div class="frais-meta">
                        <span class="classe-badge"><i class="fas fa-building"></i> {{ $frais->classe->nom_classe ?? 'N/A' }}</span>
                        <span class="status-badge status-{{ $frais->statut }}">
                            <i class="fas {{ $frais->statut == 'actif' ? 'fa-check-circle' : 'fa-ban' }}"></i>
                            {{ $frais->statut == 'actif' ? 'Actif' : 'Inactif' }}
                        </span>
                        <span class="periodicite-badge periodicite-{{ $frais->periodicite }}">
                            <i class="fas {{ $frais->periodicite == 'mensuel' ? 'fa-calendar-alt' : ($frais->periodicite == 'trimestriel' ? 'fa-calendar-week' : ($frais->periodicite == 'semestriel' ? 'fa-calendar-half' : 'fa-calendar-year')) }}"></i>
                            {{ ucfirst($frais->periodicite) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <a href="{{ route('comptable.frais.edit', $frais->id_frais) }}" class="btn-primary">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('comptable.frais.index') }}" class="btn-secondary">
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
                        <span class="info-label"><i class="fas fa-tag"></i> Libellé</span>
                        <span class="info-value">{{ $frais->libelle }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-align-left"></i> Description</span>
                        <span class="info-value">{{ $frais->description ?? 'Aucune description' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-graduation-cap"></i> Classe</span>
                        <span class="info-value">
                            <strong>{{ $frais->classe->nom_classe ?? 'N/A' }}</strong>
                            <span class="classe-niveau">({{ $frais->classe->niveau ?? 'N/A' }})</span>
                        </span>
                    </div>
                </div>

                <!-- Montant et devise -->
                <div class="info-card">
                    <h4><i class="fas fa-money-bill-wave"></i> Montant et devise</h4>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-coins"></i> Montant</span>
                        <span class="info-value">
                            <span class="montant-large">{{ number_format($frais->montant, 0, ',', ' ') }}</span>
                            <span class="devise-badge devise-{{ $frais->devise }}">{{ $frais->devise }}</span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-exclamation-triangle"></i> Pénalité de retard</span>
                        <span class="info-value">
                            @if($frais->penalite > 0)
                                <span class="penalite-value">{{ number_format($frais->penalite, 0, ',', ' ') }} {{ $frais->devise }}</span>
                            @else
                                <span class="text-muted">Aucune pénalité</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-calculator"></i> Total avec pénalité</span>
                        <span class="info-value">
                            <strong class="total-value">{{ number_format($frais->montant_avec_penalite, 0, ',', ' ') }} {{ $frais->devise }}</strong>
                            @if($frais->isDepasse())
                                <span class="depasse-warning"><i class="fas fa-clock"></i> Pénalité appliquée</span>
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Dates et échéance -->
                <div class="info-card">
                    <h4><i class="fas fa-calendar-alt"></i> Dates et échéance</h4>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-hourglass-half"></i> Date d'échéance</span>
                        <span class="info-value {{ $frais->isDepasse() ? 'text-danger' : '' }}">
                            <i class="fas fa-calendar-day"></i> {{ $frais->date_echeance->format('d/m/Y') }}
                            @if($frais->isDepasse())
                                <span class="depasse-badge"><i class="fas fa-exclamation-circle"></i> Dépassé</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-sync-alt"></i> Périodicité</span>
                        <span class="info-value">{{ ucfirst($frais->periodicite) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-plus-circle"></i> Date de création</span>
                        <span class="info-value">{{ $frais->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-edit"></i> Dernière modification</span>
                        <span class="info-value">{{ $frais->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>

                <!-- Statistiques de paiement -->
                <div class="info-card">
                    <h4><i class="fas fa-chart-line"></i> Statistiques de paiement</h4>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-chart-simple"></i> Total attendu</span>
                        <span class="info-value">{{ number_format($frais->montant * ($frais->classe->effectif ?? 0), 0, ',', ' ') }} {{ $frais->devise }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-check-circle"></i> Total payé</span>
                        <span class="info-value text-success">{{ number_format($totalPaye ?? 0, 0, ',', ' ') }} {{ $frais->devise }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-percent"></i> Taux de recouvrement</span>
                        <span class="info-value">
                            <div class="progress-cell">
                                <div class="progress-bar-cell">
                                    <div class="progress-fill" style="width: {{ $tauxRecouvrement ?? 0 }}%; background: {{ ($tauxRecouvrement ?? 0) >= 80 ? '#ef4444' : (($tauxRecouvrement ?? 0) >= 60 ? '#f59e0b' : '#10b981') }}"></div>
                                </div>
                                <span class="progress-percent">{{ $tauxRecouvrement ?? 0 }}%</span>
                            </div>
                        </span>
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
    .detail-card, .detail-header, .frais-avatar-large, .btn-primary, 
    .btn-secondary, .classe-badge, .status-badge, .periodicite-badge, 
    .info-card, .devise-badge, .progress-bar-cell, .depasse-badge {
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

    .frais-avatar-large {
        width: 85px;
        height: 85px;
        background: rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: var(--white);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .detail-header h2 {
        color: var(--white);
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .frais-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.625rem;
        align-items: center;
    }

    .classe-badge, .status-badge, .periodicite-badge {
        background: rgba(255, 255, 255, 0.15);
        padding: 0.25rem 0.75rem;
        color: var(--white);
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .classe-badge i, .status-badge i, .periodicite-badge i {
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
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .montant-large {
        font-size: 1.125rem;
        font-weight: 800;
        color: var(--dark);
    }

    .total-value {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--primary);
    }

    .classe-niveau {
        font-size: 0.688rem;
        color: var(--gray);
        margin-left: 0.25rem;
    }

    /* Devise badge */
    .devise-badge {
        padding: 0.125rem 0.5rem;
        font-size: 0.688rem;
        font-weight: 600;
    }

    .devise-FC {
        background: #d1fae5;
        color: #059669;
    }

    .devise-USD {
        background: #fef3c7;
        color: #d97706;
    }

    .penalite-value {
        color: var(--danger);
        font-weight: 600;
    }

    .text-danger {
        color: #dc2626;
        font-weight: 600;
    }

    .text-success {
        color: var(--primary);
        font-weight: 700;
    }

    .text-muted {
        color: var(--gray);
        font-style: italic;
    }

    .depasse-badge {
        background: #fee2e2;
        color: #dc2626;
        padding: 0.125rem 0.5rem;
        font-size: 0.625rem;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .depasse-warning {
        font-size: 0.688rem;
        color: var(--warning);
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
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
        
        .frais-meta {
            justify-content: center;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .header-right {
            justify-content: center;
        }
        
        .info-value {
            justify-content: flex-start;
            margin-top: 0.25rem;
        }
        
        .info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
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
        
        .frais-avatar-large {
            width: 65px;
            height: 65px;
            font-size: 1.75rem;
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