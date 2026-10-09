{{-- resources/views/parent/enfants.blade.php --}}
@extends('layouts.parent')

@section('title', 'Mes enfants')
@section('page-title', 'Mes enfants')
@section('page-subtitle', 'Liste de vos enfants inscrits')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="row g-4">
        @forelse($enfants as $enfant)
        <div class="col-lg-6">
            <div class="enfant-card">
                <div class="enfant-card-header">
                    <div class="enfant-avatar-large">
                        {{ strtoupper(substr($enfant->prenom, 0, 1)) }}{{ strtoupper(substr($enfant->nom, 0, 1)) }}
                    </div>
                    <div>
                        <h3>{{ $enfant->prenom }} {{ $enfant->nom }}</h3>
                        <div class="enfant-meta">
                            <span class="classe-badge"><i class="fas fa-building"></i> {{ $enfant->classe->nom_classe ?? 'N/A' }}</span>
                            <span class="matricule-badge"><i class="fas fa-id-card"></i> {{ $enfant->matricule ?? $enfant->id_eleve }}</span>
                        </div>
                    </div>
                </div>
                <div class="enfant-card-body">
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-calendar-alt"></i> Date de naissance</span>
                        <span class="info-value">{{ $enfant->date_naissance->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-venus-mars"></i> Sexe</span>
                        <span class="info-value">{{ $enfant->sexe == 'M' ? 'Masculin' : 'Féminin' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label"><i class="fas fa-envelope"></i> Email</span>
                        <span class="info-value">{{ $enfant->email }}</span>
                    </div>
                </div>
                <div class="enfant-card-footer">
                    <div class="stats-row">
                        <div class="stat">
                            <div class="stat-value">{{ number_format($enfant->total_paye, 0, ',', ' ') }} FC</div>
                            <div class="stat-label">Total payé</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value">{{ number_format($enfant->total_restant, 0, ',', ' ') }} FC</div>
                            <div class="stat-label">Reste à payer</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value">{{ $enfant->taux_paiement }}%</div>
                            <div class="stat-label">Taux de paiement</div>
                        </div>
                    </div>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: {{ $enfant->taux_paiement }}%"></div>
                    </div>
                    <div class="action-buttons">
                        <a href="{{ route('parent.paiement.form', ['eleve_id' => $enfant->id_eleve]) }}" class="btn-payer">
                            <i class="fas fa-credit-card"></i> Payer les frais
                        </a>
                        <a href="{{ route('parent.historique', ['eleve_id' => $enfant->id_eleve]) }}" class="btn-historique">
                            <i class="fas fa-history"></i> Voir historique
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-child fa-4x"></i>
                <h3>Aucun enfant enregistré</h3>
                <p>Vous n'avez pas encore d'enfant lié à votre compte parent.</p>
                <p>Veuillez contacter le comptable  pour lier vos enfants.</p>
                <a href="#" class="btn-primary-custom mt-3">Contacter le comptable</a>
            </div>
        </div>
        @endforelse
    </div>

</div>

@push('styles')
<style>
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }
    .col-lg-6 {
        width: 50%;
        padding: 0 10px;
        margin-bottom: 20px;
    }

    .enfant-card {
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        height: 100%;
        transition: all 0.3s;
    }
    .enfant-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .enfant-card-header {
        background: linear-gradient(135deg, #033e5b 0%, #68a2dc 100%);
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        color: white;
    }
    .enfant-avatar-large {
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 700;
    }
    .enfant-card-header h3 {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 8px 0;
    }
    .enfant-meta {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .enfant-meta .classe-badge, .enfant-meta .matricule-badge {
        background: rgba(255,255,255,0.2);
        color: white;
        font-size: 11px;
        padding: 3px 10px;
    }

    .enfant-card-body {
        padding: 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .info-label {
        font-size: 13px;
        color: #64748b;
    }
    .info-label i {
        margin-right: 8px;
        color: #0a3b5e;
    }
    .info-value {
        font-size: 13px;
        font-weight: 500;
        color: #1e293b;
    }

    .enfant-card-footer {
        padding: 20px;
    }
    .stats-row {
        display: flex;
        justify-content: space-around;
        margin-bottom: 20px;
    }
    .stat {
        text-align: center;
    }
    .stat .stat-value {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
    }
    .stat .stat-label {
        font-size: 11px;
        color: #64748b;
        margin-top: 5px;
    }
    .progress-container {
        background: #e2e8f0;
        height: 8px;
        margin-bottom: 20px;
        overflow: hidden;
    }
    .progress-container .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #e0e403, #a855f7);
        width: 0%;
    }
    .action-buttons {
        display: flex;
        gap: 12px;
    }
    .btn-payer {
        flex: 1;
        background: #387003;
        border: none;
        padding: 10px;
        color: white;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s;
    }
    .btn-payer:hover {
        background: #6b21a5;
        transform: translateY(-2px);
    }
    .btn-historique {
        flex: 1;
        background: #f1f5f9;
        border: none;
        padding: 10px;
        color: #64748b;
        font-size: 13px;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s;
    }
    .btn-historique:hover {
        background: #e2e8f0;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    .empty-state i {
        color: #c084fc;
        margin-bottom: 20px;
        display: inline-block;
    }
    .empty-state h3 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 10px;
        color: #1e293b;
    }
    .empty-state p {
        color: #64748b;
        margin-bottom: 5px;
    }
    .btn-primary-custom {
        background: #7e22ce;
        padding: 10px 25px;
        color: white;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
    }
    .btn-primary-custom:hover {
        background: #6b21a5;
        transform: translateY(-2px);
    }

    @media (max-width: 992px) {
        .col-lg-6 {
            width: 100%;
        }
    }
    @media (max-width: 768px) {
        .stats-row {
            flex-direction: column;
            gap: 15px;
        }
        .action-buttons {
            flex-direction: column;
        }
    }
</style>
@endpush
@endsection