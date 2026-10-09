{{-- resources/views/gestionnaire/users/index.blade.php --}}
@extends('layouts.gestionnaire')

@section('title', 'Utilisateurs')
@section('page-title', 'Gestion des utilisateurs')
@section('page-subtitle', 'Liste des utilisateurs du système')

@section('content')
<div class="users-container">
    <!-- En-tête avec statistiques -->
    <div class="stats-header">
        <div class="stats-items">
            <div class="stat-item">
                <div class="stat-icon bg-indigo"><i class="fas fa-users"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Total utilisateurs</span>
                    <span class="stat-number">{{ $users->total() }}</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon bg-green"><i class="fas fa-user-check"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Actifs</span>
                    <span class="stat-number">{{ $users->where('statut', 'actif')->count() }}</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon bg-red"><i class="fas fa-user-times"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Inactifs</span>
                    <span class="stat-number">{{ $users->where('statut', 'inactif')->count() }}</span>
                </div>
            </div>
        </div>
        <a href="{{ route('gestionnaire.users.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle"></i> Nouvel utilisateur
        </a>
    </div>

    <!-- Filtres de recherche -->
    <div class="filters-card">
        <form method="GET" action="{{ route('gestionnaire.users.index') }}" class="filters-form">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Rechercher par nom, email..." value="{{ request('search') }}">
            </div>
            <select name="role" class="filter-select">
                <option value="">Tous les rôles</option>
                <option value="gestionnaire" {{ request('role') == 'gestionnaire' ? 'selected' : '' }}>Gestionnaire</option>
                <option value="comptable" {{ request('role') == 'comptable' ? 'selected' : '' }}>Comptable</option>
                <option value="parent" {{ request('role') == 'parent' ? 'selected' : '' }}>Parent</option>
            </select>
            <select name="statut" class="filter-select">
                <option value="">Tous statuts</option>
                <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                <option value="inactif" {{ request('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
            </select>
            <button type="submit" class="btn-filter">Filtrer</button>
            @if(request()->anyFilled(['search', 'role', 'statut']))
                <a href="{{ route('gestionnaire.users.index') }}" class="btn-reset">Réinitialiser</a>
            @endif
        </form>
    </div>

    <!-- Tableau des utilisateurs -->
    <div class="data-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Identifiant</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Rôle</th>
                        <th>Statut</th>
                        <th>Date création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <span class="user-id">{{ $user->identifiant_unique ?? $user->id }}</span>
                        </td>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar" style="background: {{ $user->role == 'gestionnaire' ? '#4f46e5' : ($user->role == 'comptable' ? '#10b981' : '#f59e0b') }}">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="user-name">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->telephone ?? '-' }}</td>
                        <td>
                            <span class="role-badge role-{{ $user->role }}">
                                <i class="fas {{ $user->role == 'gestionnaire' ? 'fa-user-shield' : ($user->role == 'comptable' ? 'fa-calculator' : 'fa-users') }}"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="status-badge status-{{ $user->statut }}">
                                <i class="fas {{ $user->statut == 'actif' ? 'fa-check-circle' : 'fa-ban' }}"></i>
                                {{ $user->statut == 'actif' ? 'Actif' : 'Inactif' }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('gestionnaire.users.show', $user->id) }}" class="action-btn view" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('gestionnaire.users.edit', $user->id) }}" class="action-btn edit" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('gestionnaire.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" onclick="return confirm('Supprimer cet utilisateur ?')" title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="empty-state">
                            <i class="fas fa-users-slash"></i>
                            <p>Aucun utilisateur trouvé</p>
                            <a href="{{ route('gestionnaire.users.create') }}" class="btn-primary-sm">Ajouter un utilisateur</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
        <div class="pagination-container">
            {{ $users->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
/* ============================================
   GESTION DES UTILISATEURS - DESIGN MODERNE
   COINS CARRÉS - COULEURS PROFESSIONNELLES
   ============================================ */

:root {
    --primary: #4f46e5;
    --primary-dark: #4338ca;
    --primary-light: #6366f1;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #3b82f6;
    --dark: #1e293b;
    --gray: #64748b;
    --gray-light: #f8fafc;
    --white: #ffffff;
    --border: #e2e8f0;
}

.users-container {
    max-width: 1400px;
    margin: 0 auto;
}

/* Coins carrés */
.stats-header, .stat-item, .stat-icon, .filters-card, .data-card,
.search-box, .filter-select, .btn-filter, .btn-reset, .user-avatar,
.role-badge, .status-badge, .action-btn, .pagination-container {
    border-radius: 0px !important;
}

/* ==========================================
   EN-TÊTE STATISTIQUES
   ========================================== */
.stats-header {
    background: var(--white);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--border);
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.stats-items {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.stat-icon {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon i {
    font-size: 1.25rem;
}

.bg-indigo { background: #e0e7ff; color: #4f46e5; }
.bg-green { background: #d1fae5; color: #10b981; }
.bg-red { background: #fee2e2; color: #ef4444; }

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-label {
    font-size: 0.688rem;
    color: var(--gray);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-number {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark);
}

.btn-primary {
    background: var(--primary);
    color: var(--white);
    padding: 0.5rem 1.25rem;
    text-decoration: none;
    font-size: 0.813rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

/* ==========================================
   FILTRES
   ========================================== */
.filters-card {
    background: var(--white);
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--border);
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}

.filters-form {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
}

.search-box {
    flex: 2;
    position: relative;
    min-width: 200px;
}

.search-box i {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    font-size: 0.875rem;
}

.search-box input {
    width: 100%;
    padding: 0.625rem 0.75rem 0.625rem 2.25rem;
    border: 1px solid var(--border);
    font-size: 0.813rem;
    transition: all 0.3s ease;
}

.search-box input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
}

.filter-select {
    padding: 0.625rem 0.75rem;
    border: 1px solid var(--border);
    font-size: 0.813rem;
    background: var(--white);
    cursor: pointer;
    min-width: 140px;
}

.filter-select:focus {
    outline: none;
    border-color: var(--primary);
}

.btn-filter {
    background: var(--primary);
    border: none;
    padding: 0.625rem 1.5rem;
    color: var(--white);
    font-weight: 500;
    font-size: 0.813rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-filter:hover {
    background: var(--primary-dark);
}

.btn-reset {
    background: #f1f5f9;
    padding: 0.625rem 1.25rem;
    color: var(--gray);
    text-decoration: none;
    font-size: 0.813rem;
    transition: all 0.3s ease;
}

.btn-reset:hover {
    background: #e2e8f0;
    color: var(--dark);
}

/* ==========================================
   TABLEAU
   ========================================== */
.data-card {
    background: var(--white);
    border: 1px solid var(--border);
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    overflow: hidden;
}

.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th {
    background: var(--gray-light);
    padding: 0.875rem 1rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--gray);
    text-align: left;
    border-bottom: 1px solid var(--border);
}

.data-table td {
    padding: 0.875rem 1rem;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}

.data-table tr:hover {
    background: var(--gray-light);
}

/* User cell */
.user-cell {
    display: flex;
    align-items: center;
    gap: 0.625rem;
}

.user-avatar {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.875rem;
    color: var(--white);
}

.user-name {
    font-weight: 500;
    color: var(--dark);
    font-size: 0.875rem;
}

.user-id {
    font-family: monospace;
    font-size: 0.75rem;
    color: var(--gray);
    background: #f1f5f9;
    padding: 0.25rem 0.5rem;
}

/* Role badges */
.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.role-gestionnaire {
    background: #e0e7ff;
    color: #4f46e5;
}

.role-comptable {
    background: #d1fae5;
    color: #059669;
}

.role-parent {
    background: #fef3c7;
    color: #d97706;
}

/* Status badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-actif {
    background: #d1fae5;
    color: #059669;
}

.status-inactif {
    background: #fee2e2;
    color: #dc2626;
}

/* Action buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #f1f5f9;
    color: var(--gray);
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.action-btn.view:hover {
    background: var(--info);
    color: var(--white);
}

.action-btn.edit:hover {
    background: var(--warning);
    color: var(--white);
}

.action-btn.delete:hover {
    background: var(--danger);
    color: var(--white);
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 3rem;
    color: var(--gray);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state p {
    margin-bottom: 1rem;
}

.btn-primary-sm {
    background: var(--primary);
    color: var(--white);
    padding: 0.5rem 1.25rem;
    text-decoration: none;
    font-size: 0.813rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-primary-sm:hover {
    background: var(--primary-dark);
}

/* Pagination */
.pagination-container {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border);
    display: flex;
    justify-content: flex-end;
}

/* ==========================================
   RESPONSIVE
   ========================================== */
@media (max-width: 768px) {
    .stats-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .stats-items {
        width: 100%;
        justify-content: space-between;
    }
    
    .filters-form {
        flex-direction: column;
    }
    
    .search-box, .filter-select, .btn-filter, .btn-reset {
        width: 100%;
    }
    
    .action-buttons {
        flex-wrap: wrap;
    }
}

@media (max-width: 480px) {
    .stats-items {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .stat-item {
        justify-content: space-between;
        width: 100%;
    }
    
    .data-table th, .data-table td {
        padding: 0.625rem;
    }
}
</style>
@endpush
@endsection