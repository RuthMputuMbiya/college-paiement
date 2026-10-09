{{-- resources/views/gestionnaire/payments/index.blade.php --}}
@extends('layouts.gestionnaire')

@section('title', 'Paiements')
@section('page-title', 'Gestion des paiements')
@section('page-subtitle', 'Liste des transactions')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #e0e7ff; color: #4f46e5;"><i class="fas fa-receipt"></i></div>
        <div class="stat-info"><div class="stat-label">Total transactions</div><div class="stat-value">{{ $stats['total'] ?? 0 }}</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #d1fae5; color: #10b981;"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info"><div class="stat-label">Validées</div><div class="stat-value">{{ $stats['valides'] ?? 0 }}</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #fef3c7; color: #f59e0b;"><i class="fas fa-clock"></i></div>
        <div class="stat-info"><div class="stat-label">En attente</div><div class="stat-value">{{ $stats['attente'] ?? 0 }}</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #fee2e2; color: #ef4444;"><i class="fas fa-times-circle"></i></div>
        <div class="stat-info"><div class="stat-label">Échoués</div><div class="stat-value">{{ $stats['echoues'] ?? 0 }}</div></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-receipt"></i> Historique des transactions</h3>
        <button class="btn-outline" onclick="window.print()"><i class="fas fa-print"></i> Imprimer</button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead><tr><th>Référence</th><th>Élève</th><th>Montant</th><th>Opérateur</th><th>Statut</th><th>Date</th></tr></thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->reference }}</td>
                        <td>{{ $payment->eleve->prenom ?? '' }} {{ $payment->eleve->nom ?? '' }}</td>
                        <td>{{ number_format($payment->montant, 0, ',', ' ') }} FC</td>
                        <td><span class="badge badge-info">{{ ucfirst($payment->operateur) }}</span></td>
                        <td><span class="badge {{ $payment->statut == 'valide' ? 'badge-success' : ($payment->statut == 'en_attente' ? 'badge-warning' : 'badge-danger') }}">{{ $payment->statut }}</span></td>
                        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" style="text-align: center; padding: 40px;">Aucun paiement</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($payments->hasPages())
    <div class="card-footer">{{ $payments->links() }}</div>
    @endif
</div>
@endsection