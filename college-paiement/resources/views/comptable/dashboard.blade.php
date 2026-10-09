{{-- resources/views/comptable/dashboard.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Tableau de bord - Comptable')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Vue d\'ensemble de la gestion financière')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <!-- Bannière de bienvenue -->
    <div class="welcome-banner mb-4">
        <div class="welcome-content">
            <div class="welcome-text">
                <h2>Bonjour, {{ auth()->user()->name }} !</h2>
                <p>Bienvenue dans votre espace comptable. Voici les indicateurs clés du jour.</p>
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
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total parents</div>
                <div class="stat-value">{{ $stats['total_parents'] ?? 0 }}</div>
                <div class="stat-details">
                    <span class="text-blue"><i class="fas fa-check-circle"></i> Actifs: {{ $stats['parents_actifs'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="stat-card stat-green">
            <div class="stat-icon"><i class="fas fa-child"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total élèves</div>
                <div class="stat-value">{{ $stats['total_eleves'] ?? 0 }}</div>
                <div class="stat-details">
                    <span class="text-green"><i class="fas fa-building"></i> Classes: {{ $stats['total_classes'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="stat-card stat-orange">
            <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-info">
                <div class="stat-label">Montant collecté</div>
                <div class="stat-value">{{ number_format($stats['montant_total'] ?? 0, 0, ',', ' ') }} <span class="small">FC</span></div>
                <div class="stat-details">
                    <span class="text-orange"><i class="fas fa-chart-line"></i> Taux: {{ $stats['taux_recouvrement'] ?? 0 }}%</span>
                </div>
            </div>
            <div class="stat-progress">
                <div class="progress-bar" style="width: {{ $stats['taux_recouvrement'] ?? 0 }}%"></div>
            </div>
        </div>

        <div class="stat-card stat-purple">
            <div class="stat-icon"><i class="fas fa-receipt"></i></div>
            <div class="stat-info">
                <div class="stat-label">Transactions</div>
                <div class="stat-value">{{ $stats['total_paiements'] ?? 0 }}</div>
                <div class="stat-details">
                    <span class="text-purple"><i class="fas fa-check-circle"></i> Validées: {{ $stats['paiements_valides'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Deuxième ligne de stats -->
    <div class="stats-grid-secondary">
        <div class="stat-card-sm">
            <div class="stat-icon-sm bg-blue-light"><i class="fas fa-user-check"></i></div>
            <div class="stat-info-sm">
                <div class="stat-label-sm">Parents actifs</div>
                <div class="stat-value-sm">{{ $stats['parents_actifs'] ?? 0 }}</div>
            </div>
        </div>
        <div class="stat-card-sm">
            <div class="stat-icon-sm bg-green-light"><i class="fas fa-child"></i></div>
            <div class="stat-info-sm">
                <div class="stat-label-sm">Élèves/Classe</div>
                <div class="stat-value-sm">{{ $stats['moyenne_eleves_par_classe'] ?? 0 }}</div>
            </div>
        </div>
        <div class="stat-card-sm">
            <div class="stat-icon-sm bg-orange-light"><i class="fas fa-gavel"></i></div>
            <div class="stat-info-sm">
                <div class="stat-label-sm">Litiges ouverts</div>
                <div class="stat-value-sm">{{ $stats['litiges_ouverts'] ?? 0 }}</div>
            </div>
        </div>
        <div class="stat-card-sm">
            <div class="stat-icon-sm bg-purple-light"><i class="fas fa-percent"></i></div>
            <div class="stat-info-sm">
                <div class="stat-label-sm">Taux succès</div>
                <div class="stat-value-sm">{{ $stats['taux_succes'] ?? 0 }}%</div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="charts-row">
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-chart-pie"></i> Répartition des parents par statut</h3>
            </div>
            <div class="chart-body">
                <canvas id="parentsChart" height="250"></canvas>
                <div class="legend-container">
                    <div><span style="display:inline-block; width:12px; height:12px; background:#10b981;"></span> Actifs ({{ $stats['parents_actifs'] ?? 0 }})</div>
                    <div><span style="display:inline-block; width:12px; height:12px; background:#ef4444;"></span> Inactifs ({{ $stats['parents_inactifs'] ?? 0 }})</div>
                </div>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-chart-line"></i> Évolution des paiements (6 derniers mois)</h3>
            </div>
            <div class="chart-body">
                <canvas id="evolutionChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Paiements récents -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-history"></i> Derniers paiements</h3>
            <a href="{{ route('comptable.paiements.index') }}" class="btn-link">Voir tous <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="data-body p-0">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Élève</th>
                            <th>Parent</th>
                            <th>Montant</th>
                            <th>Opérateur</th>
                            <th>Statut</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPayments ?? [] as $payment)
                        <tr>
                            <td><span class="ref-badge">{{ $payment->reference }}</span></td>
                            <td>{{ $payment->eleve->prenom ?? '' }} {{ $payment->eleve->nom ?? '' }}</span></span></span></span></span></span></span>
                            <td>{{ $payment->parent->name ?? 'N/A' }}</span></span></span></span></span></span></span>
                            <td class="amount-cell">{{ number_format($payment->montant, 0, ',', ' ') }} FC</span></span></span></span></span></span></span>
                            <td>
                                <span class="operator-badge operator-{{ $payment->operateur }}">
                                    <i class="fas {{ $payment->operateur == 'airtel' ? 'fa-signal' : ($payment->operateur == 'orange' ? 'fa-circle' : 'fa-charging-station') }}"></i>
                                    {{ ucfirst($payment->operateur) }}
                                </span>
                            </span></span></span></span></span></span></span>
                            <td>
                                <span class="status-badge status-{{ $payment->statut }}">
                                    <i class="fas {{ $payment->statut == 'valide' ? 'fa-check-circle' : ($payment->statut == 'en_attente' ? 'fa-clock' : 'fa-times-circle') }}"></i>
                                    {{ $payment->statut == 'valide' ? 'Validé' : ($payment->statut == 'en_attente' ? 'En attente' : 'Échoué') }}
                                </span>
                            </span></span></span></span></span></span></span>
                            <td>{{ $payment->created_at->format('d/m/Y H:i') }}</span></span></span></span></span></span></span>
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
            <a href="{{ route('comptable.parents.create') }}" class="quick-btn"><i class="fas fa-user-plus"></i> Nouveau parent</a>
            <a href="{{ route('comptable.parents.index') }}" class="quick-btn"><i class="fas fa-users"></i> Gérer parents</a>
            <a href="{{ route('comptable.eleves.create') }}" class="quick-btn"><i class="fas fa-user-plus"></i> Nouvel élève</a>
            <a href="{{ route('comptable.classes.create') }}" class="quick-btn"><i class="fas fa-plus-circle"></i> Nouvelle classe</a>
            <a href="{{ route('comptable.frais.create') }}" class="quick-btn"><i class="fas fa-money-bill"></i> Nouveau frais</a>
            <a href="{{ route('comptable.paiements.index') }}" class="quick-btn"><i class="fas fa-search"></i> Voir paiements</a>
        </div>
    </div>

</div>

@push('styles')
<style>
    .welcome-banner {
        background: linear-gradient(135deg, #222423 0%, #047857 100%);
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
    .welcome-text p { color: #a7f3d0; font-size: 14px; margin: 0; }
    .welcome-date { background: rgba(255,255,255,0.2); padding: 10px 20px; color: white; font-size: 14px; }

    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px; }
    .stat-card { background: white; padding: 20px; position: relative; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.05); transition: all 0.3s; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
    .stat-icon { width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; }
    .stat-card.stat-blue .stat-icon { background: #eff6ff; color: #3b82f6; }
    .stat-card.stat-green .stat-icon { background: #ecfdf5; color: #10b981; }
    .stat-card.stat-orange .stat-icon { background: #fffbeb; color: #f59e0b; }
    .stat-card.stat-purple .stat-icon { background: #f5f3ff; color: #8b5cf6; }
    .stat-icon i { font-size: 24px; }
    .stat-label { font-size: 12px; color: #64748b; text-transform: uppercase; margin-bottom: 5px; }
    .stat-value { font-size: 28px; font-weight: 800; color: #1e293b; margin-bottom: 8px; }
    .stat-value .small { font-size: 14px; }
    .stat-details { font-size: 11px; }
    .text-blue { color: #3b82f6; }
    .text-green { color: #10b981; }
    .text-orange { color: #f59e0b; }
    .text-purple { color: #8b5cf6; }
    .stat-progress { position: absolute; bottom: 0; left: 0; right: 0; height: 4px; background: #e2e8f0; }
    .stat-progress .progress-bar { height: 100%; background: linear-gradient(90deg, #10b981, #34d399); }

    .stats-grid-secondary {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .stat-card-sm {
        background: white;
        padding: 15px 18px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    .stat-card-sm:hover { transform: translateY(-3px); }
    .stat-icon-sm {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-blue-light { background: #eff6ff; color: #3b82f6; }
    .bg-green-light { background: #ecfdf5; color: #10b981; }
    .bg-orange-light { background: #fffbeb; color: #f59e0b; }
    .bg-purple-light { background: #f5f3ff; color: #8b5cf6; }
    .stat-icon-sm i { font-size: 20px; }
    .stat-label-sm { font-size: 11px; color: #64748b; margin-bottom: 3px; }
    .stat-value-sm { font-size: 20px; font-weight: 700; color: #1e293b; }

    .charts-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 25px; margin-bottom: 30px; }
    .chart-card { background: white; box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow: hidden; }
    .chart-header { padding: 18px 22px; border-bottom: 1px solid #e2e8f0; }
    .chart-header h3 { font-size: 16px; font-weight: 700; margin: 0; color: #1e293b; }
    .chart-header h3 i { margin-right: 8px; color: #10b981; }
    .chart-body { padding: 20px; }
    .legend-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 15px;
    }

    .data-card { background: white; box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 30px; }
    .data-header { padding: 18px 22px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
    .data-header h3 { font-size: 16px; font-weight: 700; margin: 0; color: #1e293b; }
    .data-header h3 i { margin-right: 8px; color: #10b981; }
    .btn-link { color: #10b981; text-decoration: none; font-size: 13px; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8fafc; padding: 12px 15px; font-size: 12px; font-weight: 600; color: #64748b; text-align: left; }
    .data-table td { padding: 12px 15px; border-bottom: 1px solid #e2e8f0; }
    .ref-badge { font-family: monospace; font-size: 11px; background: #f1f5f9; padding: 4px 8px; }
    .amount-cell { font-weight: 700; color: #1e293b; }
    .operator-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; font-size: 11px; font-weight: 500; }
    .operator-airtel { background: #fee2e2; color: #dc2626; }
    .operator-orange { background: #fef3c7; color: #d97706; }
    .operator-mpesa { background: #d1fae5; color: #059669; }
    .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; font-size: 11px; font-weight: 500; }
    .status-valide { background: #d1fae5; color: #059669; }
    .status-en_attente { background: #fef3c7; color: #d97706; }
    .status-echoue { background: #fee2e2; color: #dc2626; }

    .quick-actions { background: linear-gradient(135deg, #065f46 0%, #047857 100%); padding: 25px; margin-bottom: 20px; }
    .quick-header { color: white; font-size: 16px; font-weight: 600; margin-bottom: 20px; }
    .quick-header i { margin-right: 8px; }
    .quick-grid { display: flex; flex-wrap: wrap; gap: 12px; }
    .quick-btn { background: rgba(255,255,255,0.15); padding: 10px 22px; color: white; text-decoration: none; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
    .quick-btn:hover { background: #fbbf24; color: #1e293b; transform: translateY(-2px); }

    .empty-state { text-align: center; padding: 40px; color: #94a3b8; }
    .empty-state i { font-size: 48px; margin-bottom: 15px; display: inline-block; }

    @media (max-width: 1200px) { .stats-grid, .stats-grid-secondary, .charts-row { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) { .stats-grid, .stats-grid-secondary, .charts-row { grid-template-columns: 1fr; } .welcome-content { flex-direction: column; text-align: center; } }
</style>
@endpush

@push('scripts')
<script>
    // Graphique des parents
    const parentsCtx = document.getElementById('parentsChart')?.getContext('2d');
    if (parentsCtx) {
        new Chart(parentsCtx, {
            type: 'doughnut',
            data: {
                labels: ['Parents actifs', 'Parents inactifs'],
                datasets: [{
                    data: [{{ $stats['parents_actifs'] ?? 0 }}, {{ $stats['parents_inactifs'] ?? 0 }}],
                    backgroundColor: ['#10b981', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                cutout: '60%'
            }
        });
    }

    // Graphique d'évolution
    const evolutionCtx = document.getElementById('evolutionChart')?.getContext('2d');
    if (evolutionCtx) {
        new Chart(evolutionCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($evolutionMois ?? []) !!},
                datasets: [{
                    label: 'Montant (FC)',
                    data: {!! json_encode($evolutionMontants ?? []) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.05)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#fff',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { callbacks: { label: (ctx) => `${ctx.dataset.label}: ${new Intl.NumberFormat('fr-FR').format(ctx.raw)} FC` } }
                },
                scales: { y: { beginAtZero: true, ticks: { callback: (v) => new Intl.NumberFormat('fr-FR').format(v) } } }
            }
        });
    }
</script>
@endpush
@endsection