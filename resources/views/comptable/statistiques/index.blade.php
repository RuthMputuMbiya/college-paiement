{{-- resources/views/comptable/statistiques/index.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Statistiques')
@section('page-title', 'Statistiques et rapports')
@section('page-subtitle', 'Analyse des performances financières')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <!-- Filtres de période -->
    <div class="period-filters mb-4">
        <div class="period-header">
            <i class="fas fa-chart-line"></i>
            <span>Période d'analyse</span>
        </div>
        <div class="period-buttons">
            <button class="period-btn" data-period="7">7 jours</button>
            <button class="period-btn" data-period="30">30 jours</button>
            <button class="period-btn active" data-period="90">90 jours</button>
            <button class="period-btn" data-period="365">1 an</button>
            <div class="period-custom">
                <input type="date" id="date_debut" placeholder="Date début">
                <span>à</span>
                <input type="date" id="date_fin" placeholder="Date fin">
                <button id="applyCustom" class="btn-custom">Appliquer</button>
            </div>
        </div>
    </div>

    <!-- Cartes KPI -->
    <div class="kpi-grid mb-4">
        <div class="kpi-card">
            <div class="kpi-icon"><i class="fas fa-money-bill-wave"></i></div>
            <div class="kpi-info">
                <div class="kpi-label">Chiffre d'affaires</div>
                <div class="kpi-value">{{ number_format($ca ?? 0, 0, ',', ' ') }} FC</div>
                <div class="kpi-trend {{ ($evolution ?? 0) >= 0 ? 'positive' : 'negative' }}">
                    <i class="fas {{ ($evolution ?? 0) >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                    {{ abs($evolution ?? 0) }}% vs période précédente
                </div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon"><i class="fas fa-receipt"></i></div>
            <div class="kpi-info">
                <div class="kpi-label">Transactions</div>
                <div class="kpi-value">{{ number_format($nbTransactions ?? 0, 0, ',', ' ') }}</div>
                <div class="kpi-sub">Moyenne: {{ number_format($moyenneJournaliere ?? 0, 1, ',', ' ') }}/jour</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon"><i class="fas fa-users"></i></div>
            <div class="kpi-info">
                <div class="kpi-label">Parents actifs</div>
                <div class="kpi-value">{{ number_format($parentsActifs ?? 0, 0, ',', ' ') }}</div>
                <div class="kpi-sub">{{ $tauxParentsActifs ?? 0 }}% des parents</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon"><i class="fas fa-gavel"></i></div>
            <div class="kpi-info">
                <div class="kpi-label">Litiges en cours</div>
                <div class="kpi-value">{{ number_format($litigesEnCours ?? 0, 0, ',', ' ') }}</div>
                <div class="kpi-sub">{{ $tauxLitiges ?? 0 }}% des transactions</div>
            </div>
        </div>
    </div>

    <!-- Graphiques principaux -->
    <div class="charts-row">
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-chart-line"></i> Évolution des paiements</h3>
                <div class="chart-actions">
                    <button class="chart-btn active" data-chart="line">Ligne</button>
                    <button class="chart-btn" data-chart="bar">Barres</button>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="evolutionChart" height="300"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-chart-pie"></i> Répartition par opérateur</h3>
            </div>
            <div class="chart-body">
                <canvas id="operateurChart" height="250"></canvas>
                <div class="legend-container" id="operateurLegend"></div>
            </div>
        </div>
    </div>

    <div class="charts-row">
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-chart-bar"></i> Top 5 classes par recettes</h3>
            </div>
            <div class="chart-body">
                <canvas id="topClassesChart" height="250"></canvas>
            </div>
        </div>
        <div class="chart-card">
            <div class="chart-header">
                <h3><i class="fas fa-chart-pie"></i> Répartition par type de frais</h3>
            </div>
            <div class="chart-body">
                <canvas id="fraisChart" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Tableau des performances par classe -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-building"></i> Performance par classe</h3>
            <button class="btn-export" onclick="exportToExcel()">
                <i class="fas fa-file-excel"></i> Exporter
            </button>
        </div>
        <div class="data-body p-0">
            <div class="table-responsive">
                <table class="data-table performance-table">
                    <thead>
                        <tr>
                            <th>Classe</th>
                            <th>Effectif</th>
                            <th>Montant attendu</th>
                            <th>Montant payé</th>
                            <th>Taux recouvrement</th>
                            <th>Progression</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($performanceClasses ?? [] as $classe)
                        <tr>
                            <td><strong>{{ $classe['nom_classe'] }}</strong></span></span></span></span></span></span></span>
                            <td>{{ $classe['effectif'] }}</span></span></span></span></span></span></span>
                            <td>{{ number_format($classe['attendu'], 0, ',', ' ') }} FC</span></span></span></span></span></span></span>
                            <td class="text-success">{{ number_format($classe['paye'], 0, ',', ' ') }} FC</span></span></span></span></span></span></span>
                            <td>
                                <div class="progress-cell">
                                    <div class="progress-bar-cell">
                                        <div class="progress-fill" style="width: {{ $classe['taux'] }}%; background: {{ $classe['taux'] >= 70 ? '#10b981' : ($classe['taux'] >= 40 ? '#f59e0b' : '#ef4444') }}"></div>
                                    </div>
                                    <span class="progress-text">{{ $classe['taux'] }}%</span>
                                </div>
                            </span></span></span></span></span></span></span>
                            <td>
                                <div class="trend-cell">
                                    <i class="fas {{ $classe['evolution'] >= 0 ? 'fa-arrow-up text-success' : 'fa-arrow-down text-danger' }}"></i>
                                    {{ abs($classe['evolution']) }}%
                                </div>
                            </span></span></span></span></span></span></span>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="empty-state-row"><div class="empty-state"><i class="fas fa-chart-line"></i><p>Aucune donnée disponible</p></div></span></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tableau des paiements récents -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-history"></i> Derniers paiements</h3>
            <a href="{{ route('comptable.paiements.index') }}" class="btn-link">Voir tous <i class="fas fa-arrow-right"></i></a>
        </div>
        <div class="data-body p-0">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr><th>Référence</th><th>Élève</th><th>Montant</th><th>Date</th><th>Statut</th></tr>
                    </thead>
                    <tbody>
                        @forelse($derniersPaiements ?? [] as $paiement)
                        <tr><td class="ref-badge">{{ $paiement->reference }}</span></span></span></span></span></span></span><td>{{ $paiement->eleve->prenom ?? '' }} {{ $paiement->eleve->nom ?? '' }}</span></span></span></span></span></span></span><td class="amount-cell">{{ number_format($paiement->montant, 0, ',', ' ') }} FC</span></span></span></span></span></span></span><td>{{ $paiement->created_at->format('d/m/Y') }}</span></span></span></span></span></span></span>
                        <td><span class="payment-status status-{{ $paiement->statut }}">{{ $paiement->statut == 'valide' ? 'Validé' : ($paiement->statut == 'en_attente' ? 'En attente' : 'Échoué') }}</span></span></span></span></span></span></span></tr>
                        @empty
                        <td><td colspan="5" class="empty-state-row"><div class="empty-state"><i class="fas fa-inbox"></i><p>Aucun paiement</p></div></span></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    .period-filters {
        background: white;
        padding: 20px 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    .period-header {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 15px;
    }
    .period-header i { margin-right: 8px; color: #10b981; }
    .period-buttons {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }
    .period-btn {
        background: #f1f5f9;
        border: none;
        padding: 8px 20px;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .period-btn:hover, .period-btn.active {
        background: #10b981;
        color: white;
    }
    .period-custom {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: 15px;
        padding-left: 15px;
        border-left: 1px solid #e2e8f0;
    }
    .period-custom input {
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        font-size: 13px;
    }
    .btn-custom {
        background: #3b82f6;
        border: none;
        padding: 8px 16px;
        color: white;
        font-size: 12px;
        cursor: pointer;
    }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .kpi-card {
        background: white;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    .kpi-card:hover { transform: translateY(-3px); }
    .kpi-icon {
        width: 55px;
        height: 55px;
        background: #ecfdf5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
        font-size: 24px;
    }
    .kpi-label { font-size: 12px; color: #64748b; margin-bottom: 5px; }
    .kpi-value { font-size: 24px; font-weight: 800; color: #1e293b; }
    .kpi-trend { font-size: 11px; margin-top: 5px; }
    .kpi-trend.positive { color: #10b981; }
    .kpi-trend.negative { color: #ef4444; }
    .kpi-sub { font-size: 11px; color: #94a3b8; margin-top: 5px; }

    .charts-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }
    .chart-card {
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .chart-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .chart-header h3 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        color: #1e293b;
    }
    .chart-header h3 i { margin-right: 8px; color: #10b981; }
    .chart-actions { display: flex; gap: 5px; }
    .chart-btn {
        background: #f1f5f9;
        border: none;
        padding: 4px 12px;
        font-size: 11px;
        cursor: pointer;
    }
    .chart-btn.active { background: #10b981; color: white; }
    .chart-body { padding: 20px; }

    .legend-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
        margin-top: 15px;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
    }
    .legend-color { width: 12px; height: 12px; }

    .performance-table .progress-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .progress-bar-cell {
        width: 100px;
        background: #e2e8f0;
        height: 6px;
        overflow: hidden;
    }
    .progress-fill { height: 100%; }
    .trend-cell { font-size: 12px; font-weight: 500; }
    .text-success { color: #10b981; }
    .text-danger { color: #ef4444; }

    .btn-link {
        color: #10b981;
        text-decoration: none;
        font-size: 13px;
    }

    @media (max-width: 1200px) {
        .kpi-grid { grid-template-columns: repeat(2, 1fr); }
        .charts-row { grid-template-columns: 1fr; }
    }
    @media (max-width: 768px) {
        .kpi-grid { grid-template-columns: 1fr; }
        .period-buttons { flex-direction: column; align-items: stretch; }
        .period-custom { flex-direction: column; margin-left: 0; padding-left: 0; border-left: none; border-top: 1px solid #e2e8f0; margin-top: 10px; padding-top: 10px; }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Graphique d'évolution
    const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
    let evolutionChart = new Chart(evolutionCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($evolutionLabels ?? []) !!},
            datasets: [{
                label: 'Montant (FC)',
                data: {!! json_encode($evolutionData ?? []) !!},
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
            plugins: { tooltip: { callbacks: { label: (ctx) => `${ctx.dataset.label}: ${new Intl.NumberFormat('fr-FR').format(ctx.raw)} FC` } } },
            scales: { y: { beginAtZero: true, ticks: { callback: (v) => new Intl.NumberFormat('fr-FR').format(v) } } }
        }
    });

    // Graphique opérateurs
    const operateurCtx = document.getElementById('operateurChart').getContext('2d');
    new Chart(operateurCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($operateurLabels ?? []) !!},
            datasets: [{ data: {!! json_encode($operateurData ?? []) !!}, backgroundColor: ['#dc2626', '#d97706', '#059669'], borderWidth: 0 }]
        },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { display: false } }, cutout: '60%' }
    });

    // Graphique top classes
    const topClassesCtx = document.getElementById('topClassesChart').getContext('2d');
    new Chart(topClassesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topClassesLabels ?? []) !!},
            datasets: [{ label: 'Montant (FC)', data: {!! json_encode($topClassesData ?? []) !!}, backgroundColor: '#10b981', borderRadius: 0 }]
        },
        options: { responsive: true, maintainAspectRatio: true, scales: { y: { beginAtZero: true, ticks: { callback: (v) => new Intl.NumberFormat('fr-FR').format(v) } } } }
    });

    // Graphique frais
    const fraisCtx = document.getElementById('fraisChart').getContext('2d');
    new Chart(fraisCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($fraisLabels ?? []) !!},
            datasets: [{ data: {!! json_encode($fraisData ?? []) !!}, backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6'], borderWidth: 0 }]
        },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom' } }, cutout: '60%' }
    });

    // Changement de période
    document.querySelectorAll('.period-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.period-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const period = this.dataset.period;
            fetch(`/comptable/statistiques/data?period=${period}`)
                .then(r => r.json())
                .then(data => {
                    evolutionChart.data.labels = data.labels;
                    evolutionChart.data.datasets[0].data = data.values;
                    evolutionChart.update();
                });
        });
    });

    function exportToExcel() { alert('Export Excel en cours de développement'); }
</script>
@endpush
@endsection