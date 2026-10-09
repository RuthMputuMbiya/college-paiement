{{-- resources/views/parent/dashboard.blade.php --}}
@extends('layouts.parent')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Bienvenue dans votre espace parent')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <!-- Bannière de bienvenue -->
    <div class="welcome-banner mb-4">
        <div class="welcome-content">
            <div class="welcome-text">
                <h2>Bonjour, {{ Auth::user()->name }} !</h2>
                <p>Bienvenue dans votre espace parent. Gérez les paiements scolaires de vos enfants.</p>
            </div>
            <div class="welcome-date">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ now()->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Cartes statistiques -->
    <div class="stats-grid">
        <div class="stat-card stat-purple">
            <div class="stat-icon"><i class="fas fa-child"></i></div>
            <div class="stat-info">
                <div class="stat-label">Mes enfants</div>
                <div class="stat-value">{{ $stats['total_enfants'] ?? 0 }}</div>
                <div class="stat-details">élèves inscrits</div>
            </div>
        </div>

        <div class="stat-card stat-green">
            <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total payé</div>
                <div class="stat-value">{{ number_format($stats['total_paye'] ?? 0, 0, ',', ' ') }} FC</div>
                <div class="stat-details">{{ $stats['paiements_effectues'] ?? 0 }} transactions</div>
            </div>
        </div>

        <div class="stat-card stat-orange">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <div class="stat-label">Reste à payer</div>
                <div class="stat-value">{{ number_format($stats['total_restant'] ?? 0, 0, ',', ' ') }} FC</div>
                <div class="stat-details">à régler</div>
            </div>
        </div>

        <div class="stat-card stat-blue">
            <div class="stat-icon"><i class="fas fa-percent"></i></div>
            <div class="stat-info">
                <div class="stat-label">Taux global</div>
                <div class="stat-value">{{ $stats['taux_global'] ?? 0 }}%</div>
                <div class="stat-progress-sm">
                    <div class="progress-bar-sm" style="width: {{ $stats['taux_global'] ?? 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des enfants -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-child"></i> Mes enfants</h3>
            <span class="enfant-count">{{ $enfants->count() }} enfant(s)</span>
        </div>
        <div class="data-body p-0">
            @forelse($enfants as $enfant)
            <div class="enfant-item">
                <div class="enfant-avatar">
                    {{ strtoupper(substr($enfant->prenom, 0, 1)) }}{{ strtoupper(substr($enfant->nom, 0, 1)) }}
                </div>
                <div class="enfant-info">
                    <div class="enfant-name">{{ $enfant->prenom }} {{ $enfant->nom }}</div>
                    <div class="enfant-details">
                        <span class="classe-badge"><i class="fas fa-building"></i> {{ $enfant->classe->nom_classe ?? 'N/A' }}</span>
                        <span class="matricule-badge"><i class="fas fa-id-card"></i> {{ $enfant->matricule ?? $enfant->id_eleve }}</span>
                    </div>
                </div>
                <div class="enfant-stats">
                    <div class="stat-item">
                        <span class="stat-value">{{ number_format($enfant->total_paye, 0, ',', ' ') }} FC</span>
                        <span class="stat-label">payé</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value">{{ number_format($enfant->total_restant, 0, ',', ' ') }} FC</span>
                        <span class="stat-label">restant</span>
                    </div>
                    <div class="stat-progress">
                        <div class="progress-bar" style="width: {{ $enfant->taux_paiement }}%"></div>
                        <span class="progress-text">{{ $enfant->taux_paiement }}%</span>
                    </div>
                </div>
                <div class="enfant-actions">
                    <a href="{{ route('parent.paiement.form', ['eleve_id' => $enfant->id_eleve]) }}" class="btn-payer">
                        <i class="fas fa-credit-card"></i> Payer
                    </a>
                    <button onclick="showDetails({{ $enfant->id_eleve }})" class="btn-details">
                        <i class="fas fa-eye"></i> Détails
                    </button>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-child fa-3x"></i>
                <p>Aucun enfant enregistré</p>
                <p class="empty-subtitle">Contactez le secrétariat pour lier vos enfants à votre compte</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Derniers paiements -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-history"></i> Derniers paiements</h3>
            <a href="{{ route('parent.historique') }}" class="btn-link">Voir tout <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="data-body p-0">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Élève</th>
                            <th>Frais</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Reçu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPayments as $paiement)
                        <tr>
                            <td><span class="ref-badge">{{ $paiement->reference }}</span></td>
                            <td>{{ $paiement->eleve->prenom ?? '' }} {{ $paiement->eleve->nom ?? '' }}</span></span></span></span></span></span></span>
                            <td>{{ $paiement->frais->libelle ?? 'N/A' }}</span></span></span></span></span></span></span>
                            <td>{{ number_format($paiement->montant, 0, ',', ' ') }} {{ $paiement->devise ?? 'FC' }}</span></span></span></span></span></span></span>
                            <td>{{ $paiement->created_at->format('d/m/Y') }}</span></span></span></span></span></span></span>
                            <td>
                                <span class="status-badge status-{{ $paiement->statut }}">
                                    <i class="fas {{ $paiement->statut == 'valide' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                    {{ $paiement->statut == 'valide' ? 'Validé' : 'En attente' }}
                                </span>
                            </span></span></span></span></span></span></span>
                            <td>
                                @if($paiement->statut == 'valide')
                                    <a href="{{ route('parent.recu.download', $paiement->id_paiement) }}" class="btn-pdf" target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                @else
                                    <span class="no-receipt">-</span>
                                @endif
                            </span></span></span></span></span></span></span>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="empty-state-row"><div class="empty-state"><i class="fas fa-inbox"></i><p>Aucun paiement récent</p></div></span></tr>
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
            <a href="{{ route('parent.paiement.form') }}" class="quick-btn">
                <i class="fas fa-credit-card"></i> Effectuer un paiement
            </a>
            <a href="{{ route('parent.enfants') }}" class="quick-btn">
                <i class="fas fa-child"></i> Voir mes enfants
            </a>
            <a href="{{ route('parent.historique') }}" class="quick-btn">
                <i class="fas fa-history"></i> Historique complet
            </a>
            <a href="#" class="quick-btn" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimer mon relevé
            </a>
        </div>
    </div>

</div>

@push('styles')
<style>
    .welcome-banner {
        background: linear-gradient(135deg, #0e3f5e 0%, #082556 100%);
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
    .welcome-text p { color: #e9d5ff; font-size: 14px; margin: 0; }
    .welcome-date { background: rgba(255,255,255,0.2); padding: 10px 20px; color: white; font-size: 14px; }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .stat-card {
        background: white;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
    }
    .stat-card.stat-purple .stat-icon { background: #f5f3ff; color: #05304b; }
    .stat-card.stat-green .stat-icon { background: #ecfdf5; color: #10b981; }
    .stat-card.stat-orange .stat-icon { background: #fffbeb; color: #f59e0b; }
    .stat-card.stat-blue .stat-icon { background: #eff6ff; color: #3b82f6; }
    .stat-icon i { font-size: 22px; }
    .stat-label { font-size: 11px; color: #64748b; text-transform: uppercase; margin-bottom: 5px; }
    .stat-value { font-size: 22px; font-weight: 800; color: #1e293b; }
    .stat-details { font-size: 10px; color: #94a3b8; margin-top: 5px; }
    .stat-progress-sm { margin-top: 10px; background: #e2e8f0; height: 5px; overflow: hidden; }
    .progress-bar-sm { height: 100%; background: linear-gradient(90deg, #3b383d, #735c89); }

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
    .data-header h3 i { margin-right: 8px; color: #4f4d52; }
    .enfant-count {
        background: #f3e8ff;
        padding: 4px 12px;
        font-size: 12px;
        color: #226ace;
    }
    .btn-link {
        color: #7e22ce;
        text-decoration: none;
        font-size: 13px;
    }

    .enfant-item {
        padding: 20px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        transition: all 0.3s;
    }
    .enfant-item:hover { background: #f8fafc; }
    .enfant-avatar {
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg, #e0b229 0%, #edbc0a 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 18px;
    }
    .enfant-info { flex: 1; }
    .enfant-name { font-weight: 700; font-size: 16px; color: #1e293b; margin-bottom: 5px; }
    .enfant-details { display: flex; gap: 10px; flex-wrap: wrap; }
    .classe-badge, .matricule-badge {
        font-size: 11px;
        padding: 3px 8px;
        background: #f1f5f9;
        color: #64748b;
    }
    .enfant-stats {
        min-width: 200px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .enfant-stats .stat-item {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
    }
    .enfant-stats .stat-value { font-weight: 700; color: #1e293b; }
    .enfant-stats .stat-label { color: #64748b; }
    .stat-progress {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .stat-progress .progress-bar {
        flex: 1;
        height: 6px;
        background: #e2e8f0;
        overflow: hidden;
    }
    .stat-progress .progress-bar div {
        height: 100%;
        background: linear-gradient(90deg, #625102, #052244);
    }
    .progress-text { font-size: 11px; font-weight: 600; color: #092759; }
    .enfant-actions {
        display: flex;
        gap: 10px;
    }
    .btn-payer {
        background: #061252;
        border: none;
        padding: 8px 18px;
        color: white;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-payer:hover {
        background: #081c62;
        transform: translateY(-2px);
    }
    .btn-details {
        background: #f1f5f9;
        border: none;
        padding: 8px 18px;
        color: #64748b;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-details:hover { background: #e2e8f0; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8fafc; padding: 12px 15px; font-size: 12px; font-weight: 600; color: #64748b; text-align: left; }
    .data-table td { padding: 12px 15px; border-bottom: 1px solid #e2e8f0; }
    .ref-badge { font-family: monospace; font-size: 11px; background: #f1f5f9; padding: 4px 8px; }
    .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; font-size: 11px; font-weight: 500; }
    .status-valide { background: #d1fae5; color: #059669; }
    .status-en_attente { background: #fef3c7; color: #d97706; }
    .btn-pdf { background: #ef4444; color: white; padding: 5px 10px; font-size: 11px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
    .btn-pdf:hover { background: #dc2626; }
    .no-receipt { color: #94a3b8; }

    .quick-actions {
        background: linear-gradient(135deg, #052466 0%, #021238 100%);
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
    .empty-subtitle { font-size: 12px; margin-top: 5px; }

    @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
        .enfant-item { flex-direction: column; text-align: center; }
        .enfant-stats { width: 100%; }
        .enfant-actions { width: 100%; justify-content: center; }
        .data-table { display: block; overflow-x: auto; }
    }
</style>
@endpush

@push('scripts')
<script>
    function showDetails(eleveId) {
        alert('Détails de l\'élève à venir');
    }
</script>
@endpush
@endsection