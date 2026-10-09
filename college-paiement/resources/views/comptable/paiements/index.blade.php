{{-- resources/views/comptable/paiements/index.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Gestion des paiements')
@section('page-title', 'Gestion des paiements')
@section('page-subtitle', 'Suivi des transactions de paiement scolaire')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <!-- En-tête avec statistiques -->
    <div class="stats-payment-grid mb-4">
        <div class="stat-payment-card">
            <div class="stat-icon blue"><i class="fas fa-receipt"></i></div>
            <div class="stat-info">
                <div class="stat-label">Total transactions</div>
                <div class="stat-value">{{ number_format($stats['total'] ?? 0, 0, ',', ' ') }}</div>
            </div>
        </div>
        <div class="stat-payment-card">
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
            <div class="stat-info">
                <div class="stat-label">Paiements validés</div>
                <div class="stat-value">{{ number_format($stats['valides'] ?? 0, 0, ',', ' ') }}</div>
            </div>
        </div>
        <div class="stat-payment-card">
            <div class="stat-icon amber"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <div class="stat-label">En attente</div>
                <div class="stat-value">{{ number_format($stats['en_attente'] ?? 0, 0, ',', ' ') }}</div>
            </div>
        </div>
        <div class="stat-payment-card">
            <div class="stat-icon red"><i class="fas fa-times-circle"></i></div>
            <div class="stat-info">
                <div class="stat-label">Échoués</div>
                <div class="stat-value">{{ number_format($stats['echoues'] ?? 0, 0, ',', ' ') }}</div>
            </div>
        </div>
    </div>

    <!-- Montant total collecté -->
    <div class="total-amount-card mb-4">
        <div class="amount-content">
            <i class="fas fa-money-bill-wave"></i>
            <div>
                <span class="amount-label">Montant total collecté</span>
                <span class="amount-value">{{ number_format($stats['montant_total'] ?? 0, 0, ',', ' ') }} FC</span>
            </div>
        </div>
        <div class="amount-progress">
            <div class="progress-bar" style="width: {{ $stats['taux_succes'] ?? 0 }}%"></div>
            <span class="progress-text">Taux de succès: {{ $stats['taux_succes'] ?? 0 }}%</span>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="filters-card mb-4">
        <form method="GET" action="{{ route('comptable.paiements.index') }}" class="filters-form">
            <div class="filter-group">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Réf., élève, parent..." value="{{ request('search') }}">
                </div>
                <div class="filter-select">
                    <i class="fas fa-filter"></i>
                    <select name="statut">
                        <option value="">Tous statuts</option>
                        <option value="valide" {{ request('statut') == 'valide' ? 'selected' : '' }}>Validé</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="echoue" {{ request('statut') == 'echoue' ? 'selected' : '' }}>Échoué</option>
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
                <div class="filter-select">
                    <i class="fas fa-building"></i>
                    <select name="classe_id">
                        <option value="">Toutes classes</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id_classe }}" {{ request('classe_id') == $classe->id_classe ? 'selected' : '' }}>
                                {{ $classe->nom_classe }}
                            </option>
                        @endforeach
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
                <button type="submit" class="btn-filter">Filtrer</button>
                @if(request()->anyFilled(['search', 'statut', 'operateur', 'classe_id', 'date_debut', 'date_fin']))
                    <a href="{{ route('comptable.paiements.index') }}" class="btn-reset">Réinitialiser</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tableau des paiements -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-receipt"></i> Historique des transactions</h3>
            <button class="btn-export" onclick="exportToExcel()">
                <i class="fas fa-file-excel"></i> Exporter
            </button>
        </div>
        <div class="data-body p-0">
            <div class="table-responsive">
                <table class="data-table payment-table">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Élève / Classe</th>
                            <th>Parent</th>
                            <th>Frais</th>
                            <th>Montant</th>
                            <th>Opérateur</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paiements as $paiement)
                        <tr>
                            <td><span class="ref-badge">{{ $paiement->reference }}</span></td>
                            <td>
                                <div class="student-cell">
                                    <div class="student-avatar">
                                        {{ strtoupper(substr($paiement->eleve->prenom ?? 'E', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="student-name">{{ $paiement->eleve->prenom ?? '' }} {{ $paiement->eleve->nom ?? '' }}</div>
                                        <div class="student-class">{{ $paiement->eleve->classe->nom_classe ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $paiement->parent->name ?? 'N/A' }}</span></span></span></span></span></span></span>
                            <td>{{ $paiement->frais->libelle ?? 'N/A' }}</span></span></span></span></span></span></span>
                            <td class="amount-cell">{{ number_format($paiement->montant, 0, ',', ' ') }} {{ $paiement->devise ?? 'FC' }}</span></span></span></span></span></span></span>
                            <td>
                                <span class="operator-badge operator-{{ $paiement->operateur }}">
                                    <i class="fas {{ $paiement->operateur == 'airtel' ? 'fa-signal' : ($paiement->operateur == 'orange' ? 'fa-circle' : 'fa-charging-station') }}"></i>
                                    {{ ucfirst($paiement->operateur) }}
                                </span>
                            </span></span></span></span></span></span></span>
                            <td>
                                <span class="payment-status status-{{ $paiement->statut }}">
                                    <i class="fas {{ $paiement->statut == 'valide' ? 'fa-check-circle' : ($paiement->statut == 'en_attente' ? 'fa-clock' : 'fa-times-circle') }}"></i>
                                    {{ $paiement->statut == 'valide' ? 'Validé' : ($paiement->statut == 'en_attente' ? 'En attente' : 'Échoué') }}
                                </span>
                            </span></span></span></span></span></span></span>
                            <td>{{ $paiement->created_at->format('d/m/Y H:i') }}</span></span></span></span></span></span></span>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('comptable.paiements.show', $paiement->id_paiement) }}" class="action-btn view" title="Détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('comptable.paiements.receipt', $paiement->id_paiement) }}" class="action-btn receipt" title="Reçu" target="_blank">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    @if($paiement->statut == 'en_attente')
                                        <button class="action-btn validate" onclick="validatePayment({{ $paiement->id_paiement }})" title="Valider">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                    @endif
                                </div>
                            </span></span></span></span></span></span></span>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="empty-state-row">
                                <div class="empty-state">
                                    <i class="fas fa-receipt fa-3x"></i>
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
    /* Stats Payment Grid */
    .stats-payment-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .stat-payment-card {
        background: white;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        transition: all 0.3s;
    }
    .stat-payment-card:hover { transform: translateY(-3px); }
    .stat-icon {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-icon.blue { background: #eff6ff; color: #3b82f6; }
    .stat-icon.green { background: #ecfdf5; color: #10b981; }
    .stat-icon.amber { background: #fffbeb; color: #f59e0b; }
    .stat-icon.red { background: #fef2f2; color: #ef4444; }
    .stat-icon i { font-size: 24px; }
    .stat-label { font-size: 11px; color: #64748b; text-transform: uppercase; margin-bottom: 5px; }
    .stat-value { font-size: 24px; font-weight: 800; color: #1e293b; }

    /* Total Amount Card */
    .total-amount-card {
        background: linear-gradient(135deg, #065f46 0%, #047857 100%);
        padding: 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 25px;
    }
    .amount-content {
        display: flex;
        align-items: center;
        gap: 15px;
        color: white;
    }
    .amount-content i { font-size: 32px; color: #fbbf24; }
    .amount-label { display: block; font-size: 12px; opacity: 0.7; margin-bottom: 5px; }
    .amount-value { font-size: 28px; font-weight: 800; }
    .amount-progress { flex: 1; min-width: 200px; }
    .amount-progress .progress-bar {
        height: 8px;
        background: linear-gradient(90deg, #10b981, #fbbf24);
        margin-bottom: 8px;
    }
    .progress-text { font-size: 12px; color: #a7f3d0; }

    .filters-card {
        background: white;
        padding: 20px 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    .filters-form { display: flex; flex-wrap: wrap; gap: 15px; }
    .filter-group { display: flex; flex-wrap: wrap; gap: 12px; flex: 1; }
    .search-box { flex: 2; position: relative; min-width: 200px; }
    .search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    .search-box input { width: 100%; padding: 10px 12px 10px 38px; border: 1px solid #e2e8f0; font-size: 14px; }
    .search-box input:focus { outline: none; border-color: #10b981; }
    .filter-select { position: relative; min-width: 150px; }
    .filter-select i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    .filter-select select { width: 100%; padding: 10px 12px 10px 34px; border: 1px solid #e2e8f0; font-size: 14px; background: white; cursor: pointer; appearance: none; }
    .filter-date { position: relative; min-width: 140px; }
    .filter-date i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    .filter-date input { width: 100%; padding: 10px 12px 10px 34px; border: 1px solid #e2e8f0; font-size: 14px; }
    .btn-filter { background: #10b981; border: none; padding: 0 25px; color: white; font-weight: 500; cursor: pointer; transition: all 0.3s; }
    .btn-filter:hover { background: #059669; }
    .btn-reset { background: #f1f5f9; padding: 0 20px; color: #64748b; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; transition: all 0.3s; }
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
    .data-header h3 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        color: #1e293b;
    }
    .data-header h3 i { margin-right: 8px; color: #10b981; }
    .btn-export { background: #f1f5f9; border: none; padding: 6px 15px; color: #10b981; font-size: 12px; cursor: pointer; transition: all 0.2s; }
    .btn-export:hover { background: #10b981; color: white; }
    .data-footer { padding: 15px 22px; border-top: 1px solid #e2e8f0; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8fafc; padding: 14px 15px; font-size: 12px; font-weight: 600; color: #64748b; text-align: left; }
    .data-table td { padding: 14px 15px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }

    .ref-badge {
        font-family: monospace;
        font-size: 11px;
        background: #f1f5f9;
        padding: 4px 8px;
        color: #1e293b;
    }
    .student-cell { display: flex; align-items: center; gap: 10px; }
    .student-avatar {
        width: 35px;
        height: 35px;
        background: #3b82f6;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
    }
    .student-name { font-weight: 600; font-size: 13px; color: #1e293b; }
    .student-class { font-size: 10px; color: #64748b; }
    .amount-cell { font-weight: 700; color: #1e293b; }

    .operator-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 500;
    }
    .operator-airtel { background: #fee2e2; color: #dc2626; }
    .operator-orange { background: #fef3c7; color: #d97706; }
    .operator-mpesa { background: #d1fae5; color: #059669; }

    .payment-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 500;
    }
    .status-valide { background: #d1fae5; color: #059669; }
    .status-en_attente { background: #fef3c7; color: #d97706; }
    .status-echoue { background: #fee2e2; color: #dc2626; }

    .action-buttons { display: flex; gap: 8px; }
    .action-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        background: #f1f5f9;
        color: #64748b;
        border: none;
        cursor: pointer;
    }
    .action-btn.view:hover { background: #3b82f6; color: white; }
    .action-btn.receipt:hover { background: #ef4444; color: white; }
    .action-btn.validate:hover { background: #10b981; color: white; }

    .empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
    .empty-state i { margin-bottom: 15px; display: inline-block; }

    @media (max-width: 1200px) { .stats-payment-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
        .stats-payment-grid { grid-template-columns: 1fr; }
        .total-amount-card { flex-direction: column; text-align: center; }
        .filter-group { flex-direction: column; }
        .search-box, .filter-select, .filter-date, .btn-filter, .btn-reset { width: 100%; }
        .data-table { display: block; overflow-x: auto; }
    }
</style>
@endpush

@push('scripts')
<script>
    function validatePayment(id) {
        if(confirm('Valider ce paiement ?')) {
            fetch(`/comptable/paiements/${id}/validate`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json()).then(data => {
                if(data.success) location.reload();
                else alert('Erreur lors de la validation');
            });
        }
    }
    function exportToExcel() { alert('Export Excel en cours de développement'); }
</script>
@endpush
@endsection