{{-- resources/views/comptable/litiges/show.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Détails du litige')
@section('page-title', 'Détails du litige')
@section('page-subtitle', 'Gestion et traitement du litige')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="detail-card">
        <div class="detail-header" style="background: linear-gradient(135deg, #065f46 0%, #047857 100%);">
            <div class="header-left">
                <div class="litige-avatar-large">
                    <i class="fas fa-gavel"></i>
                </div>
                <div>
                    <h2>Litige #{{ $litige->id_litige }}</h2>
                    <div class="litige-meta">
                        <span class="status-badge status-{{ $litige->statut }}">
                            <i class="fas {{ $litige->statut == 'ouvert' ? 'fa-exclamation-circle' : ($litige->statut == 'en_cours' ? 'fa-clock' : ($litige->statut == 'resolu' ? 'fa-check-circle' : 'fa-times-circle')) }}"></i>
                            {{ $litige->statut == 'ouvert' ? 'Ouvert' : ($litige->statut == 'en_cours' ? 'En cours' : ($litige->statut == 'resolu' ? 'Résolu' : 'Rejeté')) }}
                        </span>
                        <span class="date-badge">
                            <i class="fas fa-calendar-alt"></i>
                            Ouvert le {{ $litige->date_ouverture->format('d/m/Y à H:i') }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="header-right">
                @if($litige->statut != 'resolu' && $litige->statut != 'rejete')
                    <a href="{{ route('comptable.litiges.edit', $litige->id_litige) }}" class="btn-primary">
                        <i class="fas fa-gavel"></i> Traiter le litige
                    </a>
                @endif
                <a href="{{ route('comptable.litiges.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>
        </div>

        <div class="detail-body">
            <div class="info-grid">
                <!-- Informations du litige -->
                <div class="info-card">
                    <h4><i class="fas fa-info-circle"></i> Informations du litige</h4>
                    <div class="info-row">
                        <span class="info-label">ID Litige</span>
                        <span class="info-value">#{{ $litige->id_litige }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Statut</span>
                        <span class="info-value">
                            <span class="status-badge status-{{ $litige->statut }}">
                                {{ $litige->statut == 'ouvert' ? 'Ouvert' : ($litige->statut == 'en_cours' ? 'En cours' : ($litige->statut == 'resolu' ? 'Résolu' : 'Rejeté')) }}
                            </span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Date d'ouverture</span>
                        <span class="info-value">{{ $litige->date_ouverture->format('d/m/Y à H:i') }}</span>
                    </div>
                    @if($litige->date_resolution)
                    <div class="info-row">
                        <span class="info-label">Date de résolution</span>
                        <span class="info-value">{{ $litige->date_resolution->format('d/m/Y à H:i') }}</span>
                    </div>
                    @endif
                    <div class="info-row">
                        <span class="info-label">Traité par</span>
                        <span class="info-value">
                            @if($litige->traiteur)
                                <i class="fas fa-user-check"></i> {{ $litige->traiteur->name }}
                            @else
                                <span class="text-muted">Non traité</span>
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Informations du paiement -->
                <div class="info-card">
                    <h4><i class="fas fa-receipt"></i> Informations du paiement</h4>
                    <div class="info-row">
                        <span class="info-label">Référence</span>
                        <span class="info-value">
                            <span class="ref-badge">{{ $litige->paiement->reference ?? 'N/A' }}</span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Montant</span>
                        <span class="info-value">{{ number_format($litige->paiement->montant ?? 0, 0, ',', ' ') }} {{ $litige->paiement->devise ?? 'FC' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Date du paiement</span>
                        <span class="info-value">{{ $litige->paiement->date_paiement->format('d/m/Y H:i') ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Opérateur</span>
                        <span class="info-value">
                            <span class="operator-badge operator-{{ $litige->paiement->operateur ?? '' }}">
                                <i class="fas {{ $litige->paiement->operateur == 'airtel' ? 'fa-signal' : ($litige->paiement->operateur == 'orange' ? 'fa-circle' : 'fa-charging-station') }}"></i>
                                {{ ucfirst($litige->paiement->operateur ?? 'N/A') }}
                            </span>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Statut paiement</span>
                        <span class="info-value">
                            <span class="payment-status status-{{ $litige->paiement->statut ?? '' }}">
                                {{ ucfirst($litige->paiement->statut ?? 'N/A') }}
                            </span>
                        </span>
                    </div>
                </div>

                <!-- Informations parent / élève -->
                <div class="info-card">
                    <h4><i class="fas fa-users"></i> Parent / Élève</h4>
                    <div class="info-row">
                        <span class="info-label">Parent</span>
                        <span class="info-value">
                            <div class="user-info">
                                <div class="user-avatar-sm" style="background: #10b981">
                                    {{ strtoupper(substr($litige->paiement->parent->name ?? 'P', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="user-name">{{ $litige->paiement->parent->name ?? 'N/A' }}</div>
                                    <div class="user-email">{{ $litige->paiement->parent->email ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Élève</span>
                        <span class="info-value">
                            <div class="user-info">
                                <div class="user-avatar-sm" style="background: #3b82f6">
                                    {{ strtoupper(substr($litige->paiement->eleve->prenom ?? 'E', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="user-name">{{ $litige->paiement->eleve->prenom ?? '' }} {{ $litige->paiement->eleve->nom ?? '' }}</div>
                                    <div class="user-class">{{ $litige->paiement->eleve->classe->nom_classe ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Contact parent</span>
                        <span class="info-value">
                            <i class="fas fa-phone"></i> {{ $litige->paiement->eleve->telephone_parent ?? 'N/A' }}
                        </span>
                    </div>
                </div>

                <!-- Motif et solution -->
                <div class="info-card">
                    <h4><i class="fas fa-file-alt"></i> Motif et solution</h4>
                    <div class="info-row">
                        <span class="info-label">Motif</span>
                        <span class="info-value motif-text">{{ $litige->motif }}</span>
                    </div>
                    @if($litige->description)
                    <div class="info-row">
                        <span class="info-label">Description</span>
                        <span class="info-value description-text">{{ $litige->description }}</span>
                    </div>
                    @endif
                    @if($litige->solution)
                    <div class="info-row">
                        <span class="info-label">Solution apportée</span>
                        <span class="info-value solution-text">{{ $litige->solution }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions rapides -->
            @if($litige->statut != 'resolu' && $litige->statut != 'rejete')
            <div class="quick-actions-section">
                <div class="quick-header">
                    <i class="fas fa-bolt"></i> Actions rapides
                </div>
                <div class="quick-grid">
                    <a href="{{ route('comptable.litiges.edit', $litige->id_litige) }}" class="quick-btn">
                        <i class="fas fa-gavel"></i> Traiter ce litige
                    </a>
                    <a href="{{ route('comptable.paiements.show', $litige->paiement_id) }}" class="quick-btn">
                        <i class="fas fa-receipt"></i> Voir le paiement
                    </a>
                    <a href="mailto:{{ $litige->paiement->parent->email ?? '' }}" class="quick-btn">
                        <i class="fas fa-envelope"></i> Contacter le parent
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

</div>

@push('styles')
<style>
    .detail-card {
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .detail-header {
        padding: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    .header-left { display: flex; align-items: center; gap: 20px; }
    .litige-avatar-large {
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        color: white;
    }
    .detail-header h2 { color: white; font-size: 24px; font-weight: 700; margin: 0 0 8px 0; }
    .litige-meta { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
    .date-badge { background: rgba(255,255,255,0.2); padding: 4px 12px; color: white; font-size: 12px; }

    .detail-body { padding: 25px; }
    .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 25px; margin-bottom: 30px; }
    .info-card { border: 1px solid #e2e8f0; padding: 20px; }
    .info-card h4 {
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 15px 0;
        padding-bottom: 12px;
        border-bottom: 2px solid #e2e8f0;
        color: #1e293b;
    }
    .info-card h4 i { margin-right: 8px; color: #10b981; }
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .info-label { font-size: 13px; color: #64748b; width: 35%; }
    .info-value { font-size: 13px; font-weight: 500; color: #1e293b; width: 65%; }

    .ref-badge {
        font-family: monospace;
        background: #f1f5f9;
        padding: 4px 8px;
        font-size: 12px;
    }

    .operator-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 500;
    }
    .operator-airtel { background: #fee2e2; color: #dc2626; }
    .operator-orange { background: #fef3c7; color: #d97706; }
    .operator-mpesa { background: #d1fae5; color: #059669; }

    .payment-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 500;
    }
    .status-valide { background: #d1fae5; color: #059669; }
    .status-en_attente { background: #fef3c7; color: #d97706; }
    .status-echoue { background: #fee2e2; color: #dc2626; }

    .user-info { display: flex; align-items: center; gap: 10px; }
    .user-avatar-sm {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }
    .user-name { font-weight: 600; color: #1e293b; font-size: 13px; }
    .user-email { font-size: 10px; color: #64748b; }
    .user-class { font-size: 10px; color: #3b82f6; margin-top: 2px; }

    .motif-text, .description-text, .solution-text {
        word-break: break-word;
        white-space: pre-wrap;
        line-height: 1.5;
    }

    .quick-actions-section {
        background: linear-gradient(135deg, #065f46 0%, #047857 100%);
        padding: 25px;
        margin-top: 20px;
    }
    .quick-header {
        color: white;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 20px;
    }
    .quick-header i { margin-right: 8px; }
    .quick-grid { display: flex; flex-wrap: wrap; gap: 12px; }
    .quick-btn {
        background: rgba(255,255,255,0.15);
        padding: 10px 22px;
        color: white;
        text-decoration: none;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .quick-btn:hover {
        background: #fbbf24;
        color: #1e293b;
        transform: translateY(-2px);
    }

    .btn-primary {
        background: #fbbf24;
        border: none;
        padding: 10px 20px;
        color: #1e293b;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .btn-primary:hover { background: #f59e0b; transform: translateY(-2px); }
    .btn-secondary {
        background: rgba(255,255,255,0.2);
        border: none;
        padding: 10px 20px;
        color: white;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .btn-secondary:hover { background: rgba(255,255,255,0.3); }

    @media (max-width: 768px) {
        .detail-header { flex-direction: column; text-align: center; }
        .header-left { flex-direction: column; text-align: center; }
        .info-grid { grid-template-columns: 1fr; }
        .info-row { flex-direction: column; gap: 5px; }
        .info-label { width: 100%; }
        .info-value { width: 100%; }
    }
</style>
@endpush
@endsection