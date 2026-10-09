{{-- resources/views/comptable/classes/index.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Gestion des classes')
@section('page-title', 'Gestion des classes')
@section('page-subtitle', 'Gérer les classes et leurs effectifs')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <!-- En-tête avec actions -->
    <div class="page-header-card mb-4">
        <div class="header-left">
            <div class="header-stats">
                <div class="stat-badge">
                    <i class="fas fa-building"></i>
                    <span>Total: <strong>{{ $classes->total() }}</strong></span>
                </div>
                <div class="stat-badge text-success">
                    <i class="fas fa-child"></i>
                    <span>Élèves: <strong>{{ $totalEleves ?? 0 }}</strong></span>
                </div>
                <div class="stat-badge text-warning">
                    <i class="fas fa-chart-line"></i>
                    <span>Moyenne/classe: <strong>{{ $moyenneParClasse ?? 0 }}</strong></span>
                </div>
            </div>
        </div>
        <div class="header-right">
            <a href="{{ route('comptable.classes.create') }}" class="btn-primary-custom">
                <i class="fas fa-plus-circle"></i> Nouvelle classe
            </a>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="filters-card mb-4">
        <form method="GET" action="{{ route('comptable.classes.index') }}" class="filters-form">
            <div class="filter-group">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Rechercher une classe..." value="{{ request('search') }}">
                </div>
                <div class="filter-select">
                    <i class="fas fa-graduation-cap"></i>
                    <select name="niveau">
                        <option value="">Tous les niveaux</option>
                        <option value="Collège" {{ request('niveau') == 'Collège' ? 'selected' : '' }}>Collège</option>
                        <option value="Lycée" {{ request('niveau') == 'Lycée' ? 'selected' : '' }}>Lycée</option>
                    </select>
                </div>
                <div class="filter-select">
                    <i class="fas fa-calendar"></i>
                    <select name="annee_scolaire">
                        <option value="">Toutes années</option>
                        <option value="2024-2025" {{ request('annee_scolaire') == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                        <option value="2025-2026" {{ request('annee_scolaire') == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter">Filtrer</button>
                @if(request()->anyFilled(['search', 'niveau', 'annee_scolaire']))
                    <a href="{{ route('comptable.classes.index') }}" class="btn-reset">Réinitialiser</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tableau des classes -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-building"></i> Liste des classes</h3>
            <button class="btn-export" onclick="exportToExcel()">
                <i class="fas fa-file-excel"></i> Exporter
            </button>
        </div>
        <div class="data-body p-0">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nom de la classe</th>
                            <th>Niveau</th>
                            <th>Année scolaire</th>
                            <th>Capacité</th>
                            <th>Effectif</th>
                            <th>Taux remplissage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classes as $classe)
                        <tr>
                            <td>
                                <div class="classe-cell">
                                    <div class="classe-avatar">
                                        {{ strtoupper(substr($classe->nom_classe, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="classe-name">{{ $classe->nom_classe }}</div>
                                        <div class="classe-code">{{ $classe->description ?? 'Aucune description' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="niveau-badge">{{ $classe->niveau }}</span></td>
                            <td>{{ $classe->annee_scolaire }}</span></span></span></span></span></span></span>
                            <td>{{ $classe->capacite }} places</span></span></span></span></span></span></span>
                            <td>
                                <div class="effectif-cell">
                                    <span class="effectif-number">{{ $classe->effectif }}</span>
                                    <span class="effectif-total">/ {{ $classe->capacite }}</span>
                                </div>
                            </span></span></span></span></span></span></span>
                            <td>
                                <div class="progress-cell">
                                    <div class="progress-bar-cell">
                                        <div class="progress-fill" style="width: {{ $classe->taux_remplissage }}%; background: {{ $classe->taux_remplissage >= 80 ? '#ef4444' : ($classe->taux_remplissage >= 60 ? '#f59e0b' : '#10b981') }}"></div>
                                    </div>
                                    <span class="progress-text">{{ $classe->taux_remplissage }}%</span>
                                </div>
                            </span></span></span></span></span></span></span>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('comptable.classes.show', $classe->id_classe) }}" class="action-btn view" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('comptable.classes.edit', $classe->id_classe) }}" class="action-btn edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('comptable.classes.destroy', $classe->id_classe) }}" method="POST" class="delete-form" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" onclick="return confirm('Supprimer cette classe ? Tous les élèves seront également supprimés.')" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </span></span></span></span></span></span></span>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="empty-state-row">
                                <div class="empty-state">
                                    <i class="fas fa-building fa-3x"></i>
                                    <p>Aucune classe trouvée</p>
                                    <a href="{{ route('comptable.classes.create') }}" class="btn-primary-custom mt-3">Créer une classe</a>
                                </div>
                            </span>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($classes->hasPages())
        <div class="data-footer">
            {{ $classes->appends(request()->query())->links() }}
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
    .text-success { color: #0b437f; }
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
        border: none;
        cursor: pointer;
    }
    .btn-primary-custom:hover {
        background: #1b6695;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 104, 146, 0.3);
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

    .data-card { background: white; box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 30px; }
    .data-header { padding: 18px 22px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
    .data-header h3 { font-size: 16px; font-weight: 700; margin: 0; color: #1e293b; }
    .data-header h3 i { margin-right: 8px; color: #10b981; }
    .btn-export { background: #f1f5f9; border: none; padding: 6px 15px; color: #10b981; font-size: 12px; cursor: pointer; transition: all 0.2s; }
    .btn-export:hover { background: #10b981; color: white; }
    .data-footer { padding: 15px 22px; border-top: 1px solid #e2e8f0; }

    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { background: #f8fafc; padding: 14px 15px; font-size: 12px; font-weight: 600; color: #64748b; text-align: left; }
    .data-table td { padding: 14px 15px; border-bottom: 1px solid #e2e8f0; vertical-align: middle; }

    .classe-cell { display: flex; align-items: center; gap: 12px; }
    .classe-avatar { width: 45px; height: 45px; background: #10b981; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 14px; }
    .classe-name { font-weight: 600; color: #1e293b; font-size: 14px; }
    .classe-code { font-size: 11px; color: #64748b; }

    .niveau-badge { display: inline-block; padding: 4px 12px; background: #e0e7ff; color: #3b82f6; font-size: 11px; font-weight: 500; }
    .effectif-cell { display: flex; align-items: baseline; gap: 2px; }
    .effectif-number { font-weight: 700; font-size: 16px; color: #1e293b; }
    .effectif-total { font-size: 12px; color: #94a3b8; }

    .progress-cell { display: flex; align-items: center; gap: 10px; }
    .progress-bar-cell { width: 80px; background: #e2e8f0; height: 6px; overflow: hidden; }
    .progress-fill { height: 100%; }
    .progress-text { font-size: 11px; font-weight: 500; }

    .action-buttons { display: flex; gap: 8px; }
    .action-btn { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s; background: #f1f5f9; color: #64748b; border: none; cursor: pointer; }
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