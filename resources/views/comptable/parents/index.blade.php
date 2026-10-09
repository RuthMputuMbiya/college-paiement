{{-- resources/views/comptable/parents/index.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Gestion des parents')
@section('page-title', 'Parents d\'élèves')
@section('page-subtitle', 'Gérer les comptes parents')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <!-- En-tête avec statistiques -->
    <div class="stats-header mb-4">
        <div class="stat-card">
            <div class="stat-icon bg-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total parents</div>
                <div class="stat-value">{{ $parents->total() }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Comptes actifs</div>
                <div class="stat-value">{{ $stats['actifs'] ?? 0 }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-warning">
                <i class="fas fa-child"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Enfants inscrits</div>
                <div class="stat-value">{{ $stats['total_enfants'] ?? 0 }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-info">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total payé</div>
                <div class="stat-value">{{ number_format($stats['total_paye'] ?? 0, 0, ',', ' ') }} FC</div>
            </div>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('comptable.parents.index') }}" class="filter-form">
            <div class="filter-group">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Nom, email ou téléphone..." value="{{ request('search') }}">
                </div>
                <div class="filter-select">
                    <i class="fas fa-filter"></i>
                    <select name="statut">
                        <option value="">Tous les statuts</option>
                        <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ request('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
                <button type="submit" class="btn-filter">
                    <i class="fas fa-search"></i> Filtrer
                </button>
                @if(request()->anyFilled(['search', 'statut']))
                    <a href="{{ route('comptable.parents.index') }}" class="btn-reset">
                        <i class="fas fa-undo-alt"></i> Réinitialiser
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tableau des parents -->
    <div class="data-card">
        <div class="data-header">
            <h3><i class="fas fa-users"></i> Liste des parents</h3>
            <a href="{{ route('comptable.parents.create') }}" class="btn-primary">
                <i class="fas fa-user-plus"></i> Nouveau parent
            </a>
        </div>
        <div class="data-body p-0">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Identifiant</th>
                            <th>Nom complet</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Enfants</th>
                            <th>Statut</th>
                            <th>Date inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($parents as $parent)
                        <tr>
                            <td><span class="id-badge">{{ $parent->identifiant_unique ?? 'N/A' }}</span></td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar" style="background: #10b981;">
                                        {{ strtoupper(substr($parent->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="user-name">{{ $parent->name }}</div>
                                        <div class="user-role">Parent</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $parent->email }}</span></span></span></span></span></span></span>
                            <td>{{ $parent->telephone ?? '-' }}</span></span></span></span></span></span></span>
                            <td>
                                <span class="enfants-badge">
                                    <i class="fas fa-child"></i> {{ $parent->eleves->count() }} enfant(s)
                                </span>
                            </span></span></span></span></span></span></span>
                            <td>
                                <span class="status-badge status-{{ $parent->statut }}">
                                    <i class="fas {{ $parent->statut == 'actif' ? 'fa-check-circle' : 'fa-ban' }}"></i>
                                    {{ $parent->statut == 'actif' ? 'Actif' : 'Inactif' }}
                                </span>
                            </span></span></span></span></span></span></span>
                            <td>{{ $parent->created_at->format('d/m/Y') }}</span></span></span></span></span></span></span>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('comptable.parents.show', $parent->id) }}" class="action-btn view" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('comptable.parents.edit', $parent->id) }}" class="action-btn edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('comptable.parents.destroy', $parent->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" onclick="return confirm('Supprimer ce parent ?')" title="Supprimer">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </span></span></span></span></span></span></span>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="empty-state-row">
                                <div class="empty-state">
                                    <i class="fas fa-users-slash fa-3x"></i>
                                    <p>Aucun parent trouvé</p>
                                    <a href="{{ route('comptable.parents.create') }}" class="btn-primary mt-3">Ajouter un parent</a>
                                </div>
                            </span>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($parents->hasPages())
        <div class="data-footer">
            {{ $parents->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>

@push('styles')
<style>
    /* Stats Header */
    .stats-header {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .stat-card {
        background: white;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 15px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .stat-icon {
        width: 55px;
        height: 55px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    .bg-primary { background: #e0e7ff; color: #4f46e5; }
    .bg-success { background: #d1fae5; color: #10b981; }
    .bg-warning { background: #fef3c7; color: #f59e0b; }
    .bg-info { background: #e0e7ff; color: #3b82f6; }
    .stat-icon i { font-size: 24px; }
    .stat-label { font-size: 11px; color: #64748b; text-transform: uppercase; margin-bottom: 5px; }
    .stat-value { font-size: 24px; font-weight: 800; color: #1e293b; }

    /* Filter Card */
    .filter-card {
        background: white;
        padding: 20px 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .filter-form { display: flex; flex-wrap: wrap; gap: 15px; }
    .filter-group { display: flex; flex-wrap: wrap; gap: 12px; flex: 1; }
    .search-box { flex: 2; position: relative; }
    .search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    .search-box input { width: 100%; padding: 10px 12px 10px 38px; border: 1px solid #e2e8f0; font-size: 14px; }
    .search-box input:focus { outline: none; border-color: #10b981; }
    .filter-select { position: relative; min-width: 160px; }
    .filter-select i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    .filter-select select { width: 100%; padding: 10px 12px 10px 34px; border: 1px solid #e2e8f0; font-size: 14px; background: white; cursor: pointer; }
    .btn-filter {
        background: #10b981;
        border: none;
        padding: 0 25px;
        color: white;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-filter:hover { background: #059669; }
    .btn-reset {
        background: #f1f5f9;
        padding: 0 20px;
        color: #64748b;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-reset:hover { background: #e2e8f0; color: #1e293b; }

    /* Data Card */
    .data-card {
        background: white;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        overflow: hidden;
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
    .btn-primary {
        background: #10b981;
        padding: 8px 18px;
        color: white;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .btn-primary:hover {
        background: #059669;
        transform: translateY(-2px);
    }
    .data-footer { padding: 15px 22px; border-top: 1px solid #e2e8f0; }

    /* Table */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th {
        background: #f8fafc;
        padding: 12px 15px;
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-align: left;
    }
    .data-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }

    .id-badge {
        font-family: monospace;
        font-size: 11px;
        background: #f1f5f9;
        padding: 4px 8px;
    }
    .user-cell { display: flex; align-items: center; gap: 10px; }
    .user-avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 16px;
    }
    .user-name { font-weight: 600; font-size: 14px; color: #1e293b; }
    .user-role { font-size: 10px; color: #64748b; }

    .enfants-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #e0e7ff;
        color: #4f46e5;
        padding: 4px 10px;
        font-size: 12px;
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
    .empty-state i { margin-bottom: 15px; }

    @media (max-width: 1200px) { .stats-header { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
        .stats-header { grid-template-columns: 1fr; }
        .filter-group { flex-direction: column; }
        .search-box, .filter-select, .btn-filter, .btn-reset { width: 100%; }
        .data-table { display: block; overflow-x: auto; }
    }
</style>
@endpush
@endsection