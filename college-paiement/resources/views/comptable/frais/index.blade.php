{{-- resources/views/comptable/frais/index.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Gestion des frais')
@section('page-title', 'Gestion des frais scolaires')
@section('page-subtitle', 'Gérer les frais par classe (FC et USD)')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <!-- En-tête avec actions -->
    <div class="page-header-card mb-4">
        <div class="header-left">
            <div class="header-stats">
                <div class="stat-badge">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Total frais: <strong>{{ $frais->total() }}</strong></span>
                </div>
                <div class="stat-badge text-success">
                    <i class="fas fa-check-circle"></i>
                    <span>Actifs: <strong>{{ $stats['actifs'] ?? 0 }}</strong></span>
                </div>
                <div class="stat-badge text-warning">
                    <i class="fas fa-building"></i>
                    <span>Classes: <strong>{{ $stats['total_classes'] ?? 0 }}</strong></span>
                </div>
            </div>
        </div>
        <div class="header-right">
            <a href="{{ route('comptable.frais.create') }}" class="btn-primary-custom">
                <i class="fas fa-plus-circle"></i> Nouveau frais
            </a>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="filters-card mb-4">
        <form method="GET" action="{{ route('comptable.frais.index') }}" class="filters-form">
            <div class="filter-group">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Rechercher un frais..." value="{{ request('search') }}">
                </div>
                <div class="filter-select">
                    <i class="fas fa-building"></i>
                    <select name="classe_id">
                        <option value="">Toutes les classes</option>
                        @foreach($classes as $classe)
                            <option value="{{ $classe->id_classe }}" {{ request('classe_id') == $classe->id_classe ? 'selected' : '' }}>
                                {{ $classe->nom_classe }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-select">
                    <i class="fas fa-dollar-sign"></i>
                    <select name="devise">
                        <option value="">Toutes devises</option>
                        <option value="FC" {{ request('devise') == 'FC' ? 'selected' : '' }}>Franc Congolais (FC)</option>
                        <option value="USD" {{ request('devise') == 'USD' ? 'selected' : '' }}>Dollar US (USD)</option>
                    </select>
                </div>
                <div class="filter-select">
                    <i class="fas fa-circle"></i>
                    <select name="statut">
                        <option value="">Tous statuts</option>
                        <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ request('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter">Filtrer</button>
                @if(request()->anyFilled(['search', 'classe_id', 'devise', 'statut']))
                    <a href="{{ route('comptable.frais.index') }}" class="btn-reset">Réinitialiser</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tableau des frais -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-money-bill-wave"></i> Liste des frais scolaires</h3>
            <button class="btn-export" onclick="exportToExcel()">
                <i class="fas fa-file-excel"></i> Exporter
            </button>
        </div>
        <div class="data-body p-0">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Libellé</th>
                            <th>Classe</th>
                            <th>Montant</th>
                            <th>Périodicité</th>
                            <th>Échéance</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($frais as $fraisItem)
                        <tr>
                            <td>
                                <div class="frais-cell">
                                    <div class="frais-icon">
                                        <i class="fas fa-receipt"></i>
                                    </div>
                                    <div>
                                        <div class="frais-libelle">{{ $fraisItem->libelle }}</div>
                                        @if($fraisItem->description)
                                            <div class="frais-description">{{ Str::limit($fraisItem->description, 50) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><span class="classe-badge">{{ $fraisItem->classe->nom_classe ?? 'N/A' }}</span></td>
                            <td>
                                <div class="montant-cell">
                                    <span class="montant-value">{{ number_format($fraisItem->montant, 0, ',', ' ') }}</span>
                                    <span class="montant-devise devise-{{ $fraisItem->devise }}">{{ $fraisItem->devise }}</span>
                                    @if($fraisItem->penalite > 0)
                                        <span class="penalite-badge">+{{ number_format($fraisItem->penalite, 0, ',', ' ') }} {{ $fraisItem->devise }} pénalité</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="periodicite-badge periodicite-{{ $fraisItem->periodicite }}">
                                    <i class="fas {{ $fraisItem->periodicite == 'mensuel' ? 'fa-calendar-alt' : ($fraisItem->periodicite == 'trimestriel' ? 'fa-calendar-week' : ($fraisItem->periodicite == 'semestriel' ? 'fa-calendar-half' : 'fa-calendar-year')) }}"></i>
                                    {{ ucfirst($fraisItem->periodicite) }}
                                </span>
                            </td>
                            <td>
                                <div class="echeance-cell {{ $fraisItem->isDepasse() ? 'depasse' : '' }}">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ $fraisItem->date_echeance->format('d/m/Y') }}
                                    @if($fraisItem->isDepasse())
                                        <span class="depasse-badge">Dépassé</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $fraisItem->statut }}">
                                    <i class="fas {{ $fraisItem->statut == 'actif' ? 'fa-check-circle' : 'fa-ban' }}"></i>
                                    {{ $fraisItem->statut == 'actif' ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('comptable.frais.show', $fraisItem->id_frais) }}" class="action-btn view" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('comptable.frais.edit', $fraisItem->id_frais) }}" class="action-btn edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('comptable.frais.destroy', $fraisItem->id_frais) }}" method="POST" class="delete-form" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" onclick="return confirm('Supprimer ce frais ?')" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="empty-state-row">
                                <div class="empty-state">
                                    <i class="fas fa-money-bill-wave fa-3x"></i>
                                    <p>Aucun frais trouvé</p>
                                    <a href="{{ route('comptable.frais.create') }}" class="btn-primary-custom mt-3">Ajouter un frais</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($frais->hasPages())
        <div class="data-footer">
            {{ $frais->appends(request()->query())->links() }}
        </div>
        @endif
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
    .text-success { color: #10b981; }
    .text-warning { color: #f59e0b; }

    .btn-primary-custom {
        background: #10b981;
        padding: 10px 22px;
        color: white;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .btn-primary-custom:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16,185,129,0.3);
    }

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

    .frais-cell { display: flex; align-items: center; gap: 12px; }
    .frais-icon {
        width: 40px;
        height: 40px;
        background: #e0e7ff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #3b82f6;
        font-size: 18px;
    }
    .frais-libelle { font-weight: 600; color: #1e293b; font-size: 14px; }
    .frais-description { font-size: 11px; color: #64748b; margin-top: 2px; }

    .classe-badge {
        display: inline-block;
        padding: 4px 10px;
        background: #e0e7ff;
        color: #3b82f6;
        font-size: 11px;
        font-weight: 500;
    }

    .montant-cell { display: flex; flex-wrap: wrap; align-items: center; gap: 6px; }
    .montant-value { font-weight: 700; font-size: 15px; color: #1e293b; }
    .montant-devise {
        padding: 2px 6px;
        font-size: 10px;
        font-weight: 600;
        border-radius: 4px;
    }
    .devise-FC { background: #d1fae5; color: #059669; }
    .devise-USD { background: #fef3c7; color: #d97706; }
    .penalite-badge {
        font-size: 10px;
        color: #ef4444;
        background: #fee2e2;
        padding: 2px 6px;
    }

    .periodicite-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 500;
    }
    .periodicite-mensuel { background: #dbeafe; color: #2563eb; }
    .periodicite-trimestriel { background: #e0e7ff; color: #3b82f6; }
    .periodicite-semestriel { background: #c7d2fe; color: #4f46e5; }
    .periodicite-annuel { background: #ddd6fe; color: #6d28d9; }

    .echeance-cell {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: #1e293b;
    }
    .echeance-cell i { color: #64748b; }
    .echeance-cell.depasse { color: #dc2626; }
    .depasse-badge {
        background: #fee2e2;
        color: #dc2626;
        padding: 2px 6px;
        font-size: 9px;
        font-weight: 600;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 500;
    }
    .status-actif { background: #d1fae5; color: #059669; }
    .status-inactif { background: #fee2e2; color: #dc2626; }

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
    .action-btn.delete:hover { background: #ef4444; color: white; }

    .empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
    .empty-state i { margin-bottom: 15px; display: inline-block; }

    @media (max-width: 768px) {
        .page-header-card { flex-direction: column; text-align: center; }
        .header-stats { justify-content: center; }
        .filter-group { flex-direction: column; }
        .search-box, .filter-select, .btn-filter, .btn-reset { width: 100%; }
        .data-table { display: block; overflow-x: auto; }
    }
</style>
@endpush

@push('scripts')
<script>
    function exportToExcel() { alert('Export Excel en cours de développement'); }
</script>
@endpush
@endsection