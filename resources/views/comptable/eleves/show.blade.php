{{-- resources/views/comptable/eleves/show.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Détails de l\'élève')
@section('page-title', 'Détails de l\'élève')
@section('page-subtitle', 'Informations complètes de l\'élève')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="detail-card">
        <div class="detail-header" style="background: linear-gradient(135deg, #065f46 0%, #047857 100%);">
            <div class="header-left">
                <div class="eleve-avatar-large" style="background: {{ $eleve->sexe == 'M' ? '#3b82f6' : '#ec4899' }}">
                    {{ strtoupper(substr($eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleve->nom, 0, 1)) }}
                </div>
                <div>
                    <h2>{{ $eleve->prenom }} {{ $eleve->nom }}</h2>
                    <div class="eleve-meta">
                        <span class="classe-badge"><i class="fas fa-building"></i> {{ $eleve->classe->nom_classe ?? 'N/A' }}</span>
                        <span class="status-badge status-{{ $eleve->statut }}">
                            <i class="fas {{ $eleve->statut == 'inscrit' ? 'fa-check-circle' : ($eleve->statut == 'exclu' ? 'fa-ban' : 'fa-exchange-alt') }}"></i>
                            {{ $eleve->statut == 'inscrit' ? 'Inscrit' : ($eleve->statut == 'exclu' ? 'Exclu' : 'Transféré') }}
                        </span>
                        <span class="matricule-badge"><i class="fas fa-id-card"></i> {{ $eleve->matricule ?? $eleve->id_eleve }}</span>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <a href="{{ route('comptable.eleves.edit', $eleve->id_eleve) }}" class="btn-primary">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <a href="{{ route('comptable.eleves.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
            </div>
        </div>

        <div class="detail-body">
            <div class="info-grid">
                <!-- Informations personnelles -->
                <div class="info-card">
                    <h4><i class="fas fa-child"></i> Informations personnelles</h4>
                    <div class="info-row">
                        <span class="info-label">Nom complet</span>
                        <span class="info-value">{{ $eleve->prenom }} {{ $eleve->nom }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Date de naissance</span>
                        <span class="info-value">{{ $eleve->date_naissance->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Sexe</span>
                        <span class="info-value">{{ $eleve->sexe == 'M' ? 'Masculin' : 'Féminin' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email (connexion)</span>
                        <span class="info-value">{{ $eleve->email }}</span>
                    </div>
                </div>

                <!-- Informations scolaires -->
                <div class="info-card">
                    <h4><i class="fas fa-graduation-cap"></i> Informations scolaires</h4>
                    <div class="info-row">
                        <span class="info-label">Classe</span>
                        <span class="info-value">{{ $eleve->classe->nom_classe ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Niveau</span>
                        <span class="info-value">{{ $eleve->classe->niveau ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Année scolaire</span>
                        <span class="info-value">{{ $eleve->classe->annee_scolaire ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Statut</span>
                        <span class="info-value">
                            <span class="status-badge status-{{ $eleve->statut }}">
                                {{ $eleve->statut == 'inscrit' ? 'Inscrit' : ($eleve->statut == 'exclu' ? 'Exclu' : 'Transféré') }}
                            </span>
                        </span>
                    </div>
                </div>

                <!-- Informations parent -->
                <div class="info-card">
                    <h4><i class="fas fa-users"></i> Informations du parent</h4>
                    <div class="info-row">
                        <span class="info-label">Nom du parent</span>
                        <span class="info-value">{{ $eleve->nom_parent ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $eleve->email_parent ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Téléphone</span>
                        <span class="info-value">{{ $eleve->telephone_parent ?? 'Non renseigné' }}</span>
                    </div>
                </div>

                <!-- Historique des paiements -->
                <div class="info-card">
                    <h4><i class="fas fa-receipt"></i> Historique des paiements</h4>
                    @forelse($eleve->paiements->take(5) as $paiement)
                    <div class="info-row">
                        <span class="info-label">{{ $paiement->reference }}</span>
                        <span class="info-value">{{ number_format($paiement->montant, 0, ',', ' ') }} FC</span>
                    </div>
                    @empty
                    <div class="empty-message">Aucun paiement effectué</div>
                    @endforelse
                    <div class="info-row mt-2">
                        <a href="{{ route('comptable.paiements.index', ['eleve_id' => $eleve->id_eleve]) }}" class="btn-link-sm">
                            <i class="fas fa-search"></i> Voir tous les paiements
                        </a>
                    </div>
                </div>
            </div>
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
    .eleve-avatar-large {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 28px;
        font-weight: 700;
    }
    .detail-header h2 { color: white; font-size: 24px; font-weight: 700; margin: 0 0 8px 0; }
    .eleve-meta { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
    .classe-badge { background: rgba(255,255,255,0.2); padding: 4px 12px; color: white; font-size: 12px; }
    .matricule-badge { background: rgba(255,255,255,0.2); padding: 4px 12px; color: white; font-size: 12px; font-family: monospace; }
    .status-badge { background: rgba(255,255,255,0.2); padding: 4px 12px; color: white; font-size: 12px; }
    .header-right { display: flex; gap: 12px; }
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

    .detail-body { padding: 25px; }
    .info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 25px; }
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
    .info-label { font-size: 13px; color: #64748b; }
    .info-value { font-size: 13px; font-weight: 500; color: #1e293b; }
    .empty-message { text-align: center; padding: 20px; color: #94a3b8; font-size: 13px; }
    .btn-link-sm {
        color: #10b981;
        text-decoration: none;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-link-sm:hover { text-decoration: underline; }

    @media (max-width: 768px) {
        .detail-header { flex-direction: column; text-align: center; }
        .header-left { flex-direction: column; text-align: center; }
        .info-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush
@endsection