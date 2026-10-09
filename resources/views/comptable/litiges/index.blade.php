{{-- resources/views/comptable/litiges/index.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Gestion des litiges')
@section('page-title', 'Gestion des litiges')
@section('page-subtitle', 'Gérer les réclamations et litiges de paiement')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <!-- En-tête avec actions -->
    <div class="page-header-card mb-4">
        <div class="header-left">
            <div class="header-stats">
                <div class="stat-badge">
                    <i class="fas fa-gavel"></i>
                    <span>Total: <strong>{{ $litiges->total() }}</strong></span>
                </div>
                <div class="stat-badge text-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Ouverts: <strong>{{ $stats['ouverts'] ?? 0 }}</strong></span>
                </div>
                <div class="stat-badge text-warning">
                    <i class="fas fa-clock"></i>
                    <span>En cours: <strong>{{ $stats['en_cours'] ?? 0 }}</strong></span>
                </div>
                <div class="stat-badge text-success">
                    <i class="fas fa-check-circle"></i>
                    <span>Résolus: <strong>{{ $stats['resolus'] ?? 0 }}</strong></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="filters-card mb-4">
        <form method="GET" action="{{ route('comptable.litiges.index') }}" class="filters-form">
            <div class="filter-group">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Rechercher un litige..." value="{{ request('search') }}">
                </div>
                <div class="filter-select">
                    <i class="fas fa-tag"></i>
                    <select name="statut">
                        <option value="">Tous les statuts</option>
                        <option value="ouvert" {{ request('statut') == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                        <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="resolu" {{ request('statut') == 'resolu' ? 'selected' : '' }}>Résolu</option>
                        <option value="rejete" {{ request('statut') == 'rejete' ? 'selected' : '' }}>Rejeté</option>
                    </select>
                </div>
                <div class="filter-date">
                    <i class="fas fa-calendar"></i>
                    <input type="date" name="date_debut" placeholder="Date début" value="{{ request('date_debut') }}">
                </div>
                <div class="filter-date">
                    <i class="fas fa-calendar"></i>
                    <input type="date" name="date_fin" placeholder="Date fin" value="{{ request('date_fin') }}">
                </div>
                <button type="submit" class="btn-filter">Filtrer</button>
                @if(request()->anyFilled(['search', 'statut', 'date_debut', 'date_fin']))
                    <a href="{{ route('comptable.litiges.index') }}" class="btn-reset">Réinitialiser</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tableau des litiges -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-gavel"></i> Liste des litiges</h3>
            <button class="btn-export" onclick="exportToExcel()">
                <i class="fas fa-file-excel"></i> Exporter
            </button>
        </div>
        <div class="data-body p-0">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Référence paiement</th>
                            <th>Parent / Élève</th>
                            <th>Motif</th>
                            <th>Date ouverture</th>
                            <th>Statut</th>
                            <th>Traité par</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($litiges as $litige)
                        <tr>
                            <td><span class="id-badge">#{{ $litige->id_litige }}</span></td>
                            <td>
                                <div class="payment-ref">
                                    <i class="fas fa-receipt"></i>
                                    <span>{{ $litige->paiement->reference ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar-sm" style="background: #10b981">
                                        {{ strtoupper(substr($litige->paiement->parent->name ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="user-name">{{ $litige->paiement->parent->name ?? 'N/A' }}</div>
                                        <div class="user-sub">{{ $litige->paiement->eleve->prenom ?? '' }} {{ $litige->paiement->eleve->nom ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="motif-cell">
                                    <span class="motif-text">{{ Str::limit($litige->motif, 50) }}</span>
                                    @if(strlen($litige->motif) > 50)
                                        <button class="motif-more" onclick="showMotif('{{ addslashes($litige->motif) }}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="date-cell">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $litige->date_ouverture->format('d/m/Y') }}
                                    <span class="date-time">{{ $litige->date_ouverture->format('H:i') }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $litige->statut }}">
                                    <i class="fas {{ $litige->statut == 'ouvert' ? 'fa-exclamation-circle' : ($litige->statut == 'en_cours' ? 'fa-clock' : ($litige->statut == 'resolu' ? 'fa-check-circle' : 'fa-times-circle')) }}"></i>
                                    {{ $litige->statut == 'ouvert' ? 'Ouvert' : ($litige->statut == 'en_cours' ? 'En cours' : ($litige->statut == 'resolu' ? 'Résolu' : 'Rejeté')) }}
                                </span>
                            </td>
                            <td>
                                @if($litige->traiteur)
                                    <div class="traiteur-cell">
                                        <i class="fas fa-user-check"></i>
                                        {{ $litige->traiteur->name }}
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('comptable.litiges.show', $litige->id_litige) }}" class="action-btn view" title="Traiter">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($litige->statut != 'resolu' && $litige->statut != 'rejete')
                                        <a href="{{ route('comptable.litiges.edit', $litige->id_litige) }}" class="action-btn edit" title="Traiter">
                                            <i class="fas fa-gavel"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="empty-state-row">
                                <div class="empty-state">
                                    <i class="fas fa-gavel fa-3x"></i>
                                    <p>Aucun litige trouvé</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($litiges->hasPages())
        <div class="data-footer">
            {{ $litiges->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>

<!-- Modal Motif -->
<div id="motifModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-file-alt"></i> Motif du litige</h3>
            <button class="modal-close" onclick="closeMotifModal()">&times;</button>
        </div>
        <div class="modal-body">
            <p id="motifText"></p>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary" onclick="closeMotifModal()">Fermer</button>
        </div>
    </div>
</div>

@push('styles')
<style>
    .page-header-card {
        background: white;
        padding: 20px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    .header-stats { display: flex; gap: 20px; }
    .stat-badge { padding: 6px 14px; background: #f8fafc; font-size: 13px; color: #1e293b; }
    .stat-badge i { margin-right: 6px; }
    .text-danger { color: #dc2626; }
    .text-warning { color: #f59e0b; }
    .text-success { color: #10b981; }

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
    .filter-select { position: relative; min-width: 160px; }
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

    .id-badge {
        font-family: monospace;
        font-size: 12px;
        background: #f1f5f9;
        padding: 4px 8px;
        color: #1e293b;
    }

    .payment-ref {
        display: flex;
        align-items: center;
        gap: 6px;
        font-family: monospace;
        font-size: 11px;
        background: #f1f5f9;
        padding: 4px 8px;
        color: #1e293b;
    }
    .payment-ref i { color: #10b981; }

    .user-cell { display: flex; align-items: center; gap: 10px; }
    .user-avatar-sm {
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }
    .user-name { font-weight: 600; color: #1e293b; font-size: 13px; }
    .user-sub { font-size: 10px; color: #64748b; }

    .motif-cell {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .motif-text { font-size: 12px; color: #1e293b; }
    .motif-more {
        background: none;
        border: none;
        color: #3b82f6;
        cursor: pointer;
        font-size: 12px;
    }
    .motif-more:hover { color: #2563eb; }

    .date-cell {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
    }
    .date-cell i { color: #64748b; }
    .date-time { font-size: 10px; color: #94a3b8; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 500;
    }
    .status-ouvert { background: #fee2e2; color: #dc2626; }
    .status-en_cours { background: #fef3c7; color: #d97706; }
    .status-resolu { background: #d1fae5; color: #059669; }
    .status-rejete { background: #f1f5f9; color: #64748b; }

    .traiteur-cell {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
    }
    .traiteur-cell i { color: #10b981; }

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
    .action-btn.edit:hover { background: #f59e0b; color: white; }

    .text-muted { color: #94a3b8; }

    /* Modal */
    .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1100;
    }
    .modal-content {
        background: white;
        max-width: 500px;
        width: 90%;
        overflow: hidden;
    }
    .modal-header {
        padding: 15px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #1e293b;
        color: white;
    }
    .modal-header h3 { margin: 0; font-size: 16px; }
    .modal-header h3 i { margin-right: 8px; }
    .modal-close {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
    }
    .modal-body { padding: 20px; }
    .modal-body p { font-size: 14px; line-height: 1.6; color: #1e293b; }
    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
    }

    .empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
    .empty-state i { margin-bottom: 15px; display: inline-block; }

    @media (max-width: 768px) {
        .page-header-card { flex-direction: column; text-align: center; }
        .header-stats { justify-content: center; }
        .filter-group { flex-direction: column; }
        .search-box, .filter-select, .filter-date, .btn-filter, .btn-reset { width: 100%; }
        .data-table { display: block; overflow-x: auto; }
    }
</style>
@endpush

@push('scripts')
<script>
    function showMotif(motif) {
        document.getElementById('motifText').innerHTML = motif;
        document.getElementById('motifModal').style.display = 'flex';
    }
    
    function closeMotifModal() {
        document.getElementById('motifModal').style.display = 'none';
    }
    
    window.onclick = function(event) {
        const modal = document.getElementById('motifModal');
        if (event.target == modal) {
            closeMotifModal();
        }
    }
    
    function exportToExcel() { alert('Export Excel en cours de développement'); }
</script>
@endpush
@endsection