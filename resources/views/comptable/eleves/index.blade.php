{{-- resources/views/comptable/eleves/index.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Gestion des élèves')
@section('page-title', 'Gestion des élèves')
@section('page-subtitle', 'Gérer les élèves inscrits')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <!-- En-tête avec actions -->
    <div class="page-header-card mb-4">
        <div class="header-left">
            <div class="header-stats">
                <div class="stat-badge">
                    <i class="fas fa-child"></i>
                    <span>Total: <strong>{{ $eleves->total() }}</strong></span>
                </div>
                <div class="stat-badge text-success">
                    <i class="fas fa-check-circle"></i>
                    <span>Inscrits: <strong>{{ $stats['inscrits'] ?? 0 }}</strong></span>
                </div>
                <div class="stat-badge text-warning">
                    <i class="fas fa-building"></i>
                    <span>Classes: <strong>{{ $stats['total_classes'] ?? 0 }}</strong></span>
                </div>
            </div>
        </div>
        <div class="header-right">
            <a href="{{ route('comptable.eleves.create') }}" class="btn-primary-custom">
                <i class="fas fa-user-plus"></i> Nouvel élève
            </a>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="filters-card mb-4">
        <form method="GET" action="{{ route('comptable.eleves.index') }}" class="filters-form">
            <div class="filter-group">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Rechercher un élève (nom, prénom, email)..." value="{{ request('search') }}">
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
                    <i class="fas fa-circle"></i>
                    <select name="statut">
                        <option value="">Tous les statuts</option>
                        <option value="inscrit" {{ request('statut') == 'inscrit' ? 'selected' : '' }}>Inscrit</option>
                        <option value="exclu" {{ request('statut') == 'exclu' ? 'selected' : '' }}>Exclu</option>
                        <option value="transfere" {{ request('statut') == 'transfere' ? 'selected' : '' }}>Transféré</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter">Filtrer</button>
                @if(request()->anyFilled(['search', 'classe_id', 'statut']))
                    <a href="{{ route('comptable.eleves.index') }}" class="btn-reset">Réinitialiser</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tableau des élèves -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-child"></i> Liste des élèves</h3>
            <button class="btn-export" onclick="exportToExcel()">
                <i class="fas fa-file-excel"></i> Exporter
            </button>
        </div>
        <div class="data-body p-0">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Matricule</th>
                            <th>Nom complet</th>
                            <th>Classe</th>
                            <th>Parent</th>
                            <th>Contact parent</th>
                            <th>Statut</th>
                            <th>Date inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($eleves as $eleve)
                        <tr>
                            <td><input type="checkbox" class="eleve-checkbox" value="{{ $eleve->id_eleve }}"></td>
                            <td><span class="matricule-badge">{{ $eleve->matricule ?? $eleve->id_eleve }}</span></td>
                            <td>
                                <div class="eleve-cell">
                                    <div class="eleve-avatar" style="background: {{ $eleve->sexe == 'M' ? '#3b82f6' : '#ec4899' }}">
                                        {{ strtoupper(substr($eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleve->nom, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="eleve-name">{{ $eleve->prenom }} {{ $eleve->nom }}</div>
                                        <div class="eleve-email">{{ $eleve->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="classe-badge">{{ $eleve->classe->nom_classe ?? 'N/A' }}</span></td>
                            <td>{{ $eleve->nom_parent ?? 'Non renseigné' }}</span></span></span></span></span></span></span>
                            <td>{{ $eleve->telephone_parent ?? 'Non renseigné' }}</span></span></span></span></span></span></span>
                            <td>
                                <span class="status-badge status-{{ $eleve->statut }}">
                                    <i class="fas {{ $eleve->statut == 'inscrit' ? 'fa-check-circle' : ($eleve->statut == 'exclu' ? 'fa-ban' : 'fa-exchange-alt') }}"></i>
                                    {{ $eleve->statut == 'inscrit' ? 'Inscrit' : ($eleve->statut == 'exclu' ? 'Exclu' : 'Transféré') }}
                                </span>
                            </td>
                            <td>{{ $eleve->created_at->format('d/m/Y') }}</span></span></span></span></span></span></span>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('comptable.eleves.show', $eleve->id_eleve) }}" class="action-btn view" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('comptable.eleves.edit', $eleve->id_eleve) }}" class="action-btn edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('comptable.eleves.destroy', $eleve->id_eleve) }}" method="POST" class="delete-form" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" onclick="return confirm('Supprimer cet élève ?')" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="empty-state-row">
                                <div class="empty-state">
                                    <i class="fas fa-child fa-3x"></i>
                                    <p>Aucun élève trouvé</p>
                                    <a href="{{ route('comptable.eleves.create') }}" class="btn-primary-custom mt-3">Ajouter un élève</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($eleves->hasPages())
        <div class="data-footer">
            {{ $eleves->appends(request()->query())->links() }}
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

    .matricule-badge {
        font-family: monospace;
        font-size: 11px;
        background: #f1f5f9;
        padding: 4px 8px;
        color: #1e293b;
    }

    .eleve-cell { display: flex; align-items: center; gap: 12px; }
    .eleve-avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }
    .eleve-name { font-weight: 600; color: #1e293b; font-size: 14px; }
    .eleve-email { font-size: 11px; color: #64748b; }

    .classe-badge {
        display: inline-block;
        padding: 4px 10px;
        background: #e0e7ff;
        color: #3b82f6;
        font-size: 11px;
        font-weight: 500;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 500;
    }
    .status-inscrit { background: #d1fae5; color: #059669; }
    .status-exclu { background: #fee2e2; color: #dc2626; }
    .status-transfere { background: #fef3c7; color: #d97706; }

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
    document.getElementById('selectAll')?.addEventListener('change', function() {
        document.querySelectorAll('.eleve-checkbox').forEach(cb => cb.checked = this.checked);
    });
    function exportToExcel() { alert('Export Excel en cours de développement'); }
</script>
@endpush
@endsection