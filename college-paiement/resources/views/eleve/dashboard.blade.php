{{-- resources/views/eleve/dashboard.blade.php --}}
@extends('layouts.eleve')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Bienvenue dans votre espace élève')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <!-- Bannière de bienvenue -->
    <div class="welcome-banner mb-4">
        <div class="welcome-content">
            <div class="welcome-text">
                <h2>Bonjour, {{ session('eleve_nom', 'Élève') }} !</h2>
                <p>Bienvenue dans votre espace personnel. Voici un récapitulatif de votre situation scolaire.</p>
            </div>
            <div class="welcome-date">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ now()->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Cartes statistiques -->
    <div class="stats-grid">
        <div class="stat-card stat-blue">
            <div class="stat-icon"><i class="fas fa-building"></i></div>
            <div class="stat-info">
                <div class="stat-label">Ma classe</div>
                <div class="stat-value">{{ $eleve->classe->nom_classe ?? 'N/A' }}</div>
                <div class="stat-details">{{ $eleve->classe->niveau ?? '' }}</div>
            </div>
        </div>

        <div class="stat-card stat-green">
            <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total payé</div>
                <div class="stat-value">{{ number_format($stats['total_paye'] ?? 0, 0, ',', ' ') }} FC</div>
                <div class="stat-details">{{ $stats['nb_paiements'] ?? 0 }} paiements effectués</div>
            </div>
        </div>

        <div class="stat-card stat-orange">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <div class="stat-label">Reste à payer</div>
                <div class="stat-value">{{ number_format($stats['total_restant'] ?? 0, 0, ',', ' ') }} FC</div>
                <div class="stat-details">@if(($stats['total_restant'] ?? 0) == 0) <span class="text-success">✓ À jour</span> @endif</div>
            </div>
        </div>

        <div class="stat-card stat-purple">
            <div class="stat-icon"><i class="fas fa-percent"></i></div>
            <div class="stat-info">
                <div class="stat-label">Taux de paiement</div>
                <div class="stat-value">{{ $stats['taux_paiement'] ?? 0 }}%</div>
                <div class="stat-progress-sm">
                    <div class="progress-bar-sm" style="width: {{ $stats['taux_paiement'] ?? 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Frais à payer -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-clock"></i> Frais à payer</h3>
        </div>
        <div class="data-body p-0">
            @forelse($fraisAPayer ?? [] as $item)
            <div class="frais-item {{ $item['est_depasse'] ? 'depasse' : '' }}">
                <div class="frais-info">
                    <div class="frais-libelle">{{ $item['frais']->libelle }}</div>
                    <div class="frais-periodicite">
                        <i class="fas fa-calendar-alt"></i> {{ ucfirst($item['frais']->periodicite) }}
                    </div>
                </div>
                <div class="frais-details">
                    <div class="frais-montant">
                        <span class="montant">{{ number_format($item['montant'], 0, ',', ' ') }} {{ $item['frais']->devise ?? 'FC' }}</span>
                        @if($item['est_depasse'])
                            <span class="penalite-badge">+ pénalité</span>
                        @endif
                    </div>
                    <div class="frais-echeance">
                        <i class="fas fa-calendar-alt"></i> Échéance: {{ $item['frais']->date_echeance->format('d/m/Y') }}
                        @if($item['est_depasse'])
                            <span class="depasse-badge">Dépassé</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-check-circle fa-3x text-success"></i>
                <p>Félicitations ! Vous êtes à jour dans vos paiements.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Derniers paiements -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-history"></i> Derniers paiements</h3>
            <a href="{{ route('eleve.paiements') }}" class="btn-link">Voir tous <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="data-body p-0">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Frais</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Reçu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paiements->take(5) as $paiement)
                        <tr>
                            <td><span class="ref-badge">{{ $paiement->reference }}</span></td>
                            <td>{{ $paiement->frais->libelle ?? 'N/A' }}</span></span></span></span></span></span></span>
                            <td>{{ number_format($paiement->montant, 0, ',', ' ') }} {{ $paiement->devise ?? 'FC' }}</span></span></span></span></span></span></span>
                            <td>{{ $paiement->created_at->format('d/m/Y') }}</span></span></span></span></span></span></span>
                            <td>
                                <span class="status-badge status-{{ $paiement->statut }}">
                                    <i class="fas {{ $paiement->statut == 'valide' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                    {{ $paiement->statut == 'valide' ? 'Validé' : 'En attente' }}
                                </span>
                            </span></span></span></span></span></span></span>
                            <td>
                                <a href="{{ route('eleve.recu.download', $paiement->id_paiement) }}" class="btn-pdf" target="_blank">
                                    <i class="fas fa-file-pdf"></i> PDF
                                </a>
                            </span></span></span></span></span></span></span>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="empty-state-row"><div class="empty-state"><i class="fas fa-inbox"></i><p>Aucun paiement effectué</p></div></span></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="quick-actions">
        <div class="quick-header"><i class="fas fa-bolt"></i> Actions rapides</div>
        <div class="quick-grid">
            <a href="#" class="quick-btn" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimer mon relevé
            </a>
            <!-- Changement: route('eleve.profile.edit') → route('eleve.profile.index') -->
            <a href="{{ route('eleve.profile.index') }}" class="quick-btn">
                <i class="fas fa-user-edit"></i> Modifier mon profil
            </a>
        </div>
    </div>

</div>

@push('styles')
<style>
    .welcome-banner {
        background: linear-gradient(135deg, #f08112 0%, #6caacb 100%);
        padding: 25px 30px;
    }
    .welcome-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .welcome-text h2 { color: white; font-size: 22px; font-weight: 700; margin: 0 0 5px 0; }
    .welcome-text p { color: #fed7aa; font-size: 14px; margin: 0; }
    .welcome-date { background: rgba(255,255,255,0.2); padding: 10px 20px; color: white; font-size: 14px; }

    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px; }
    .stat-card { background: white; padding: 20px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); transition: all 0.3s; }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-icon { width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; }
    .stat-card.stat-blue .stat-icon { background: #eff6ff; color: #3b82f6; }
    .stat-card.stat-green .stat-icon { background: #ecfdf5; color: #10b981; }
    .stat-card.stat-orange .stat-icon { background: #fffbeb; color: #f59e0b; }
    .stat-card.stat-purple .stat-icon { background: #f5f3ff; color: #8b5cf6; }
    .stat-icon i { font-size: 24px; }
    .stat-label { font-size: 12px; color: #64748b; text-transform: uppercase; margin-bottom: 5px; }
    .stat-value { font-size: 24px; font-weight: 800; color: #1e293b; }
    .stat-details { font-size: 11px; color: #64748b; margin-top: 5px; }
    .text-success { color: #10b981; }
    .stat-progress-sm { margin-top: 10px; background: #e2e8f0; height: 6px; overflow: hidden; }
    .progress-bar-sm { height: 100%; background: linear-gradient(90deg, #5c564d, #0cc1ea); }

    .data-card {
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 30px;
    }
    .data-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .data-header h3 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        color: #1e293b;
    }
    .data-header h3 i { margin-right: 8px; color: #ea580c; }
    .btn-link {
        color: #ea580c;
        text-decoration: none;
        font-size: 13px;
    }

    .frais-item {
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        transition: all 0.3s;
    }
    .frais-item:hover { background: #f8fafc; }
    .frais-item.depasse { background: #fef2f2; }
    .frais-libelle { font-weight: 600; color: #1e293b; margin-bottom: 5px; }
    .frais-periodicite { font-size: 11px; color: #64748b; }
    .frais-montant { text-align: right; }
    .montant { font-weight: 700; font-size: 16px; color: #1e293b; }
    .penalite-badge { background: #fee2e2; color: #dc2626; padding: 2px 6px; margin-left: 8px; }
    .frais-echeance { font-size: 11px; color: #64748b; margin-top: 5px; }
    .depasse-badge { background: #fee2e2; color: #dc2626; padding: 2px 6px; margin-left: 8px; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8fafc; padding: 12px 15px; font-size: 12px; font-weight: 600; color: #64748b; text-align: left; }
    .data-table td { padding: 12px 15px; border-bottom: 1px solid #e2e8f0; }
    .ref-badge { font-family: monospace; font-size: 11px; background: #f1f5f9; padding: 4px 8px; }
    .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; font-size: 11px; font-weight: 500; }
    .status-valide { background: #d1fae5; color: #059669; }
    .status-en_attente { background: #fef3c7; color: #d97706; }
    .btn-pdf { background: #ef4444; color: white; padding: 5px 10px; font-size: 11px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
    .btn-pdf:hover { background: #dc2626; }

    .quick-actions {
        background: linear-gradient(135deg, #0c95ea 0%, #c2410c 100%);
        padding: 25px;
        margin-bottom: 20px;
    }
    .quick-header { color: white; font-size: 16px; font-weight: 600; margin-bottom: 20px; }
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
    .quick-btn:hover { background: #fbbf24; color: #1e293b; transform: translateY(-2px); }

    .empty-state { text-align: center; padding: 40px; color: #94a3b8; }
    .empty-state i { margin-bottom: 15px; display: inline-block; }

    @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .frais-item { flex-direction: column; text-align: center; }
        .frais-montant { text-align: center; }
        .data-table { display: block; overflow-x: auto; }
    }
</style>
@endpush
@endsection