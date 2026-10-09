{{-- resources/views/gestionnaire/dashboard/index.blade.php --}}
@extends('layouts.gestionnaire')

@section('title', 'Tableau de bord - Gestionnaire')
@section('page-title', 'Tableau de bord')
@section('page-subtitle', 'Vue d\'ensemble de la gestion du système')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <!-- Bannière de bienvenue -->
    <div class="welcome-banner mb-4">
        <div class="welcome-content">
            <div class="welcome-text">
                <h2>Bonjour, {{ auth()->user()->name }} !</h2>
                <p>Bienvenue dans votre espace gestionnaire. Voici les indicateurs clés du système.</p>
            </div>
            <div class="welcome-date">
                <i class="fas fa-calendar-alt"></i>
                <span>{{ now()->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>

    <!-- Cartes statistiques -->
    <div class="stats-grid">
        <div class="stat-card stat-indigo">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-label">Utilisateurs</div>
                <div class="stat-value">{{ $stats['total_users'] ?? 0 }}</div>
                <div class="stat-details">
                    <span class="text-indigo"><i class="fas fa-check-circle"></i> Actifs: {{ $stats['users_actifs'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <div class="stat-card stat-green">
            <div class="stat-icon"><i class="fas fa-child"></i></div>
            <div class="stat-info">
                <div class="stat-label">Élèves</div>
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
            <div class="stat-icon-sm bg-indigo-light"><i class="fas fa-user-shield"></i></div>
            <div class="stat-info-sm">
                <div class="stat-label-sm">Gestionnaires</div>
                <div class="stat-value-sm">{{ $stats['gestionnaires'] ?? 0 }}</div>
            </div>
        </div>
        <div class="stat-card-sm">
            <div class="stat-icon-sm bg-green-light"><i class="fas fa-calculator"></i></div>
            <div class="stat-info-sm">
                <div class="stat-label-sm">Comptables</div>
                <div class="stat-value-sm">{{ $stats['comptables'] ?? 0 }}</div>
            </div>
        </div>
        <div class="stat-card-sm">
            <div class="stat-icon-sm bg-orange-light"><i class="fas fa-users"></i></div>
            <div class="stat-info-sm">
                <div class="stat-label-sm">Parents</div>
                <div class="stat-value-sm">{{ $stats['parents'] ?? 0 }}</div>
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
                <h3><i class="fas fa-chart-pie"></i> Répartition des utilisateurs par rôle</h3>
            </div>
            <div class="chart-body">
                <canvas id="rolesChart" height="250"></canvas>
                <div class="legend-container">
                    <div><span style="display:inline-block; width:12px; height:12px; background:#6366f1;"></span> Gestionnaires ({{ $stats['gestionnaires'] ?? 0 }})</div>
                    <div><span style="display:inline-block; width:12px; height:12px; background:#06b6d4;"></span> Comptables ({{ $stats['comptables'] ?? 0 }})</div>
                    <div><span style="display:inline-block; width:12px; height:12px; background:#f59e0b;"></span> Parents ({{ $stats['parents'] ?? 0 }})</div>
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

    <!-- Performance par classe -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-building"></i> Performance par classe</h3>
            <button class="btn-export" onclick="exportToExcel()"><i class="fas fa-file-excel"></i> Exporter</button>
        </div>
        <div class="data-body p-0">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr><th>Classe</th><th>Élèves</th><th>Montant attendu</th><th>Montant payé</th><th>Taux</th><th>Progression</th></tr>
                    </thead>
                    <tbody>
                        @forelse($statsParClasse ?? [] as $classe)
                        <tr>
                            <td><strong>{{ $classe['nom_classe'] }}</strong></strong></td>
                            <td>{{ $classe['nb_eleves'] }}</span></td>
                            <td>{{ number_format($classe['montant_attendu'], 0, ',', ' ') }} FC</span></td>
                            <td class="text-success">{{ number_format($classe['montant_paye'], 0, ',', ' ') }} FC</span></td>
                            <td><span class="status-badge {{ $classe['taux'] >= 70 ? 'status-success' : ($classe['taux'] >= 40 ? 'status-warning' : 'status-danger') }}">{{ $classe['taux'] }}%</span></span></td>
                            <td><div class="progress-cell"><div class="progress-bar-cell"><div class="progress-fill" style="width: {{ $classe['taux'] }}%; background: {{ $classe['taux'] >= 70 ? '#10b981' : ($classe['taux'] >= 40 ? '#f59e0b' : '#ef4444') }}"></div></div></div></td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="empty-state-row"><div class="empty-state"><i class="fas fa-inbox"></i><p>Aucune donnée disponible</p></div></span></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Activités récentes -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-history"></i> Activités récentes</h3>
            <a href="{{ route('gestionnaire.logs.index') }}" class="btn-link">Voir tous <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="data-body p-0">
            @forelse($activitesRecentes ?? [] as $activite)
            <div class="activity-item">
                <div class="activity-icon"><i class="fas fa-user-circle"></i></div>
                <div class="activity-content">
                    <p class="activity-text">{{ $activite->description ?? 'Connexion utilisateur' }}</p>
                    <div class="activity-meta">
                        <span><i class="fas fa-user"></i> {{ $activite->user->name ?? 'Système' }}</span>
                        <span><i class="fas fa-clock"></i> {{ $activite->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="activity-time">{{ $activite->created_at->format('H:i') }}</div>
            </div>
            @empty
            <div class="empty-state"><i class="fas fa-inbox"></i><p>Aucune activité récente</p></div>
            @endforelse
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="quick-actions">
        <div class="quick-header"><i class="fas fa-bolt"></i> Actions rapides</div>
        <div class="quick-grid">
            <a href="{{ route('gestionnaire.users.create') }}" class="quick-btn"><i class="fas fa-user-plus"></i> Nouvel utilisateur</a>
            <a href="{{ route('gestionnaire.users.index') }}" class="quick-btn"><i class="fas fa-users"></i> Gérer utilisateurs</a>
            <a href="{{ route('gestionnaire.payments.index') }}" class="quick-btn"><i class="fas fa-receipt"></i> Voir paiements</a>
            <a href="{{ route('gestionnaire.logs.index') }}" class="quick-btn"><i class="fas fa-history"></i> Voir logs</a>
        </div>
    </div>

</div>

@push('styles')
<style>
    .welcome-banner {
        background: linear-gradient(135deg, #1e293b 0%, #2491f1 100%);
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
    .welcome-text p { color: #c7d2fe; font-size: 14px; margin: 0; }
    .welcome-date { background: rgba(255,255,255,0.2); padding: 10px 20px; color: white; font-size: 14px; }

    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px; }
    .stat-card { background: white; padding: 20px; position: relative; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.05); transition: all 0.3s; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
    .stat-icon { width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; margin-bottom: 15px; }
    .stat-card.stat-indigo .stat-icon { background: #e0e7ff; color: #4f46e5; }
    .stat-card.stat-green .stat-icon { background: #ecfdf5; color: #10b981; }
    .stat-card.stat-orange .stat-icon { background: #fffbeb; color: #f59e0b; }
    .stat-card.stat-purple .stat-icon { background: #f5f3ff; color: #8b5cf6; }
    .stat-icon i { font-size: 24px; }
    .stat-label { font-size: 12px; color: #64748b; text-transform: uppercase; margin-bottom: 5px; }
    .stat-value { font-size: 28px; font-weight: 800; color: #1e293b; margin-bottom: 8px; }
    .stat-value .small { font-size: 14px; }
    .stat-details { font-size: 11px; }
    .text-indigo { color: #4f46e5; }
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
    .bg-indigo-light { background: #e0e7ff; color: #4f46e5; }
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
    .chart-header h3 i { margin-right: 8px; color: #4f46e5; }
    .chart-body { padding: 20px; }
    .legend-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 15px;
        font-size: 12px;
    }

    .data-card { background: white; box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 30px; }
    .data-header { padding: 18px 22px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
    .data-header h3 { font-size: 16px; font-weight: 700; margin: 0; color: #1e293b; }
    .data-header h3 i { margin-right: 8px; color: #4f46e5; }
    .btn-link { color: #4f46e5; text-decoration: none; font-size: 13px; }
    .btn-export { background: #f1f5f9; border: none; padding: 6px 15px; color: #10b981; font-size: 12px; cursor: pointer; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8fafc; padding: 12px 15px; font-size: 12px; font-weight: 600; color: #64748b; text-align: left; }
    .data-table td { padding: 12px 15px; border-bottom: 1px solid #e2e8f0; }
    .status-badge { padding: 4px 10px; font-size: 11px; font-weight: 600; display: inline-block; }
    .status-success { background: #d1fae5; color: #059669; }
    .status-warning { background: #fef3c7; color: #d97706; }
    .status-danger { background: #fee2e2; color: #dc2626; }
    .progress-cell { width: 100px; }
    .progress-bar-cell { background: #e2e8f0; height: 6px; overflow: hidden; }
    .progress-fill { height: 100%; }
    .text-success { color: #10b981; }

    .activity-item { display: flex; align-items: center; gap: 15px; padding: 15px 22px; border-bottom: 1px solid #e2e8f0; transition: all 0.2s; }
    .activity-item:hover { background: #f8fafc; }
    .activity-icon { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; background: #e0e7ff; color: #4f46e5; }
    .activity-content { flex: 1; }
    .activity-text { font-size: 14px; color: #1e293b; margin: 0 0 5px 0; }
    .activity-meta { display: flex; gap: 15px; font-size: 11px; color: #94a3b8; }
    .activity-time { font-size: 12px; color: #94a3b8; }

    .quick-actions { background: linear-gradient(135deg, #1e293b 0%, #4f46e5 100%); padding: 25px; margin-bottom: 20px; }
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Graphique des rôles
    const rolesCtx = document.getElementById('rolesChart')?.getContext('2d');
    if (rolesCtx) {
        new Chart(rolesCtx, {
            type: 'doughnut',
            data: {
                labels: ['Gestionnaires', 'Comptables', 'Parents'],
                datasets: [{
                    data: [{{ $stats['gestionnaires'] ?? 0 }}, {{ $stats['comptables'] ?? 0 }}, {{ $stats['parents'] ?? 0 }}],
                    backgroundColor: ['#6366f1', '#06b6d4', '#f59e0b'],
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
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.05)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#6366f1',
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

    function exportToExcel() { alert('Export Excel en cours de développement'); }
</script>
@endpush
@endsection