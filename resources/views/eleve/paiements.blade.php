{{-- resources/views/eleve/paiements.blade.php --}}
@extends('layouts.eleve')

@section('title', 'Mes paiements')
@section('page-title', 'Historique des paiements')
@section('page-subtitle', 'Consultez tous vos paiements effectués')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <!-- Résumé des paiements -->
    <div class="summary-grid mb-4">
        <div class="summary-card">
            <div class="summary-icon"><i class="fas fa-receipt"></i></div>
            <div class="summary-info">
                <div class="summary-label">Total des paiements</div>
                <div class="summary-value">{{ number_format($stats['total_paye'] ?? 0, 0, ',', ' ') }} FC</div>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon"><i class="fas fa-chart-line"></i></div>
            <div class="summary-info">
                <div class="summary-label">Nombre de transactions</div>
                <div class="summary-value">{{ $stats['nb_paiements'] ?? 0 }}</div>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon"><i class="fas fa-calendar-alt"></i></div>
            <div class="summary-info">
                <div class="summary-label">Dernier paiement</div>
                <div class="summary-value">{{ $stats['dernier_paiement'] ?? 'Aucun' }}</div>
            </div>
        </div>
        <div class="summary-card">
            <div class="summary-icon"><i class="fas fa-percent"></i></div>
            <div class="summary-info">
                <div class="summary-label">Taux de paiement</div>
                <div class="summary-value">{{ $stats['taux_paiement'] ?? 0 }}%</div>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="filters-card mb-4">
        <form method="GET" action="{{ route('eleve.paiements') }}" class="filters-form">
            <div class="filter-group">
                <div class="filter-select">
                    <i class="fas fa-filter"></i>
                    <select name="statut">
                        <option value="">Tous statuts</option>
                        <option value="valide" {{ request('statut') == 'valide' ? 'selected' : '' }}>Validé</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                    </select>
                </div>
                <div class="filter-select">
                    <i class="fas fa-mobile-alt"></i>
                    <select name="operateur">
                        <option value="">Tous opérateurs</option>
                        <option value="airtel" {{ request('operateur') == 'airtel' ? 'selected' : '' }}>Airtel Money</option>
                        <option value="orange" {{ request('operateur') == 'orange' ? 'selected' : '' }}>Orange Money</option>
                        <option value="mpesa" {{ request('operateur') == 'mpesa' ? 'selected' : '' }}>M-Pesa</option>
                    </select>
                </div>
                <div class="filter-date">
                    <i class="fas fa-calendar"></i>
                    <input type="date" name="date_debut" value="{{ request('date_debut') }}">
                </div>
                <div class="filter-date">
                    <i class="fas fa-calendar"></i>
                    <input type="date" name="date_fin" value="{{ request('date_fin') }}">
                </div>
                <button type="submit" class="btn-filter">
                    <i class="fas fa-search"></i> Filtrer
                </button>
                @if(request()->anyFilled(['statut', 'operateur', 'date_debut', 'date_fin']))
                    <a href="{{ route('eleve.paiements') }}" class="btn-reset">
                        <i class="fas fa-undo-alt"></i> Réinitialiser
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tableau des paiements -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-receipt"></i> Historique des transactions</h3>
            <button class="btn-export" onclick="window.print()">
                <i class="fas fa-print"></i> Imprimer
            </button>
        </div>
        <div class="data-body p-0">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Frais</th>
                            <th>Montant</th>
                            <th>Opérateur</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Reçu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paiements as $paiement)
                        <tr>
                            <td><span class="ref-badge">{{ $paiement->reference }}</span></td>
                            <td>{{ $paiement->frais->libelle ?? 'N/A' }}</span></span></span></span></span></span></span>
                            <td>
                                <span class="amount-cell">
                                    {{ number_format($paiement->montant, 0, ',', ' ') }}
                                    <span class="devise-badge">{{ $paiement->devise ?? 'FC' }}</span>
                                </span>
                            </span></span></span></span></span></span></span>
                            <td>
                                <span class="operator-badge operator-{{ $paiement->operateur }}">
                                    <i class="fas {{ $paiement->operateur == 'airtel' ? 'fa-signal' : ($paiement->operateur == 'orange' ? 'fa-circle' : 'fa-charging-station') }}"></i>
                                    {{ ucfirst($paiement->operateur) }}
                                </span>
                            </span></span></span></span></span></span></span>
                            <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</span></span></span></span></span></span></span>
                            <td>
                                <span class="status-badge status-{{ $paiement->statut }}">
                                    <i class="fas {{ $paiement->statut == 'valide' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                                    {{ $paiement->statut == 'valide' ? 'Validé' : 'En attente' }}
                                </span>
                            </span></span></span></span></span></span></span>
                            <td>
                                @if($paiement->statut == 'valide')
                                    <a href="{{ route('eleve.recu.download', $paiement->id_paiement) }}" class="btn-pdf" target="_blank">
                                        <i class="fas fa-file-pdf"></i> PDF
                                    </a>
                                @else
                                    <span class="no-receipt">-</span>
                                @endif
                            </span></span></span></span></span></span></span>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="empty-state-row">
                                <div class="empty-state">
                                    <i class="fas fa-inbox fa-3x"></i>
                                    <p>Aucun paiement trouvé</p>
                                </div>
                            </span>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($paiements->hasPages())
        <div class="data-footer">
            {{ $paiements->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>

@push('styles')
<style>
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .summary-card {
        background: white;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    .summary-card:hover { transform: translateY(-3px); }
    .summary-icon {
        width: 50px;
        height: 50px;
        background: #fef3c7;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ea580c;
        font-size: 20px;
    }
    .summary-label { font-size: 11px; color: #64748b; text-transform: uppercase; margin-bottom: 5px; }
    .summary-value { font-size: 20px; font-weight: 700; color: #1e293b; }

    .filters-card {
        background: white;
        padding: 20px 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    .filters-form { display: flex; flex-wrap: wrap; gap: 15px; }
    .filter-group { display: flex; flex-wrap: wrap; gap: 12px; flex: 1; }
    .filter-select { position: relative; min-width: 160px; }
    .filter-select i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    .filter-select select { width: 100%; padding: 10px 12px 10px 34px; border: 1px solid #e2e8f0; font-size: 14px; background: white; cursor: pointer; appearance: none; }
    .filter-date { position: relative; min-width: 140px; }
    .filter-date i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    .filter-date input { width: 100%; padding: 10px 12px 10px 34px; border: 1px solid #e2e8f0; font-size: 14px; }
    .btn-filter { background: #ea580c; border: none; padding: 0 25px; color: white; font-weight: 500; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; }
    .btn-filter:hover { background: #c2410c; }
    .btn-reset { background: #f1f5f9; padding: 0 20px; color: #64748b; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
    .btn-reset:hover { background: #e2e8f0; color: #1e293b; }

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
    .data-header h3 { font-size: 16px; font-weight: 700; margin: 0; color: #1e293b; }
    .data-header h3 i { margin-right: 8px; color: #ea580c; }
    .btn-export { background: #f1f5f9; border: none; padding: 6px 15px; color: #ea580c; font-size: 12px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; }
    .btn-export:hover { background: #ea580c; color: white; }
    .data-footer { padding: 15px 22px; border-top: 1px solid #e2e8f0; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8fafc; padding: 12px 15px; font-size: 12px; font-weight: 600; color: #64748b; text-align: left; }
    .data-table td { padding: 12px 15px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }
    .ref-badge { font-family: monospace; font-size: 11px; background: #f1f5f9; padding: 4px 8px; }
    .amount-cell { font-weight: 700; color: #1e293b; }
    .devise-badge { font-size: 10px; font-weight: 500; background: #e2e8f0; padding: 2px 5px; margin-left: 5px; }
    .operator-badge { display: inline-flex; align-items: center; gap: 6px; padding: 4px 10px; font-size: 11px; font-weight: 500; }
    .operator-airtel { background: #fee2e2; color: #dc2626; }
    .operator-orange { background: #fef3c7; color: #d97706; }
    .operator-mpesa { background: #d1fae5; color: #059669; }
    .status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; font-size: 11px; font-weight: 500; }
    .status-valide { background: #d1fae5; color: #059669; }
    .status-en_attente { background: #fef3c7; color: #d97706; }
    .btn-pdf { background: #ef4444; color: white; padding: 5px 10px; font-size: 11px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; transition: all 0.2s; }
    .btn-pdf:hover { background: #dc2626; }
    .no-receipt { color: #94a3b8; font-size: 12px; }
    .empty-state { text-align: center; padding: 40px; color: #94a3b8; }
    .empty-state i { margin-bottom: 15px; display: inline-block; }

    @media (max-width: 1200px) { .summary-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
        .summary-grid { grid-template-columns: 1fr; }
        .filter-group { flex-direction: column; }
        .filter-select, .filter-date, .btn-filter, .btn-reset { width: 100%; }
        .data-table { display: block; overflow-x: auto; }
    }
</style>
@endpush
@endsection