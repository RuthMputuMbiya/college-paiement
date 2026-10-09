{{-- resources/views/gestionnaire/statistiques/index.blade.php --}}
@extends('layouts.gestionnaire')

@section('title', 'Statistiques')
@section('page-title', 'Statistiques et rapports')
@section('page-subtitle', 'Analyse des données du système')

@section('content')
<div class="stats-grid">
    <div class="stat-card"><div class="stat-icon" style="background: #e0e7ff; color: #4f46e5;"><i class="fas fa-users"></i></div><div class="stat-info"><div class="stat-label">Utilisateurs</div><div class="stat-value">{{ $stats['total_users'] ?? 0 }}</div></div></div>
    <div class="stat-card"><div class="stat-icon" style="background: #d1fae5; color: #10b981;"><i class="fas fa-child"></i></div><div class="stat-info"><div class="stat-label">Élèves</div><div class="stat-value">{{ $stats['total_eleves'] ?? 0 }}</div></div></div>
    <div class="stat-card"><div class="stat-icon" style="background: #fef3c7; color: #f59e0b;"><i class="fas fa-money-bill-wave"></i></div><div class="stat-info"><div class="stat-label">Montant collecté</div><div class="stat-value">{{ number_format($stats['montant_total'] ?? 0, 0, ',', ' ') }} FC</div></div></div>
    <div class="stat-card"><div class="stat-icon" style="background: #fee2e2; color: #ef4444;"><i class="fas fa-receipt"></i></div><div class="stat-info"><div class="stat-label">Transactions</div><div class="stat-value">{{ $stats['total_paiements'] ?? 0 }}</div></div></div>
</div>

<div class="card"><div class="card-header"><h3><i class="fas fa-chart-pie"></i> Répartition par rôle</h3></div><div class="card-body"><canvas id="rolesChart" height="300"></canvas></div></div>
<div class="card"><div class="card-header"><h3><i class="fas fa-chart-line"></i> Évolution des paiements</h3></div><div class="card-body"><canvas id="paymentChart" height="300"></canvas></div></div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    new Chart(document.getElementById('rolesChart'), {
        type: 'doughnut',
        data: { labels: {!! json_encode($rolesLabels ?? []) !!}, datasets: [{ data: {!! json_encode($rolesData ?? []) !!}, backgroundColor: ['#4f46e5', '#10b981', '#f59e0b'], borderWidth: 0 }] },
        options: { responsive: true, maintainAspectRatio: true, cutout: '60%' }
    });
    new Chart(document.getElementById('paymentChart'), {
        type: 'line',
        data: { labels: {!! json_encode($evolutionMois ?? []) !!}, datasets: [{ label: 'Montant (FC)', data: {!! json_encode($evolutionMontants ?? []) !!}, borderColor: '#4f46e5', backgroundColor: 'rgba(79,70,229,0.05)', borderWidth: 2, fill: true, tension: 0.4 }] },
        options: { responsive: true, maintainAspectRatio: true, scales: { y: { beginAtZero: true, ticks: { callback: v => new Intl.NumberFormat('fr-FR').format(v) } } } }
    });
</script>
@endpush
@endsection