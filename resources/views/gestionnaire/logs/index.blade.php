{{-- resources/views/gestionnaire/logs/index.blade.php --}}
@extends('layouts.gestionnaire')

@section('title', 'Logs système')
@section('page-title', 'Historique des activités')
@section('page-subtitle', 'Journal des connexions et actions')

@section('content')
<div class="logs-container">

    <!-- En-tête avec statistiques -->
    <div class="stats-header">
        <div class="stats-items">
            <div class="stat-item">
                <div class="stat-icon bg-indigo"><i class="fas fa-history"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Total activités</span>
                    <span class="stat-number">{{ $logs->total() ?? 0 }}</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon bg-green"><i class="fas fa-sign-in-alt"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Connexions</span>
                    <span class="stat-number">{{ $stats['connexions'] ?? 0 }}</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon bg-orange"><i class="fas fa-edit"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Modifications</span>
                    <span class="stat-number">{{ $stats['modifications'] ?? 0 }}</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon bg-red"><i class="fas fa-trash-alt"></i></div>
                <div class="stat-info">
                    <span class="stat-label">Suppressions</span>
                    <span class="stat-number">{{ $stats['suppressions'] ?? 0 }}</span>
                </div>
            </div>
        </div>
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Imprimer
        </button>
    </div>

    <!-- Filtres de recherche -->
    <div class="filters-card">
        <form method="GET" action="{{ route('gestionnaire.logs.index') }}" class="filters-form">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" name="search" placeholder="Rechercher par utilisateur, action..." value="{{ request('search') }}">
            </div>
            <select name="action" class="filter-select">
                <option value="">Toutes actions</option>
                <option value="connexion" {{ request('action') == 'connexion' ? 'selected' : '' }}>Connexion</option>
                <option value="creation" {{ request('action') == 'creation' ? 'selected' : '' }}>Création</option>
                <option value="modification" {{ request('action') == 'modification' ? 'selected' : '' }}>Modification</option>
                <option value="suppression" {{ request('action') == 'suppression' ? 'selected' : '' }}>Suppression</option>
                <option value="paiement" {{ request('action') == 'paiement' ? 'selected' : '' }}>Paiement</option>
            </select>
            <div class="date-input">
                <i class="fas fa-calendar-alt"></i>
                <input type="date" name="date_debut" placeholder="Date début" value="{{ request('date_debut') }}">
            </div>
            <div class="date-input">
                <i class="fas fa-calendar-alt"></i>
                <input type="date" name="date_fin" placeholder="Date fin" value="{{ request('date_fin') }}">
            </div>
            <button type="submit" class="btn-filter">Filtrer</button>
            @if(request()->anyFilled(['search', 'action', 'date_debut', 'date_fin']))
                <a href="{{ route('gestionnaire.logs.index') }}" class="btn-reset">Réinitialiser</a>
            @endif
        </form>
    </div>

    <!-- Tableau des logs -->
    <div class="data-card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-clock"></i> Date/Heure</th>
                        <th><i class="fas fa-user"></i> Utilisateur</th>
                        <th><i class="fas fa-envelope"></i> Email</th>
                        <th><i class="fas fa-tag"></i> Action</th>
                        <th><i class="fas fa-network-wired"></i> IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="log-date">
                            <i class="far fa-calendar-alt"></i>
                            @if(isset($log->created_at))
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            @elseif(isset($log->last_activity))
                                {{ date('d/m/Y H:i:s', $log->last_activity) }}
                            @else
                                {{ date('d/m/Y H:i:s') }}
                            @endif
                        </td>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar" style="background: {{ isset($log->user->role) && $log->user->role == 'gestionnaire' ? '#4f46e5' : (isset($log->user->role) && $log->user->role == 'comptable' ? '#10b981' : '#f59e0b') }}">
                                    {{ isset($log->user) && $log->user ? strtoupper(substr($log->user->name, 0, 1)) : 'S' }}
                                </div>
                                <div class="user-info">
                                    <span class="user-name">
                                        @if(isset($log->user) && $log->user)
                                            {{ $log->user->name }}
                                        @elseif(isset($log->user_id))
                                            ID: {{ $log->user_id }}
                                        @else
                                            Système
                                        @endif
                                    </span>
                                    <span class="user-role">
                                        @if(isset($log->user) && $log->user)
                                            {{ ucfirst($log->user->role ?? '') }}
                                        @else
                                            Système
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="log-email">
                            @if(isset($log->user) && $log->user)
                                {{ $log->user->email }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @php
                                $actionType = 'default';
                                $actionIcon = 'fa-info-circle';
                                if(isset($log->description)) {
                                    if(str_contains($log->description, 'connexion') || str_contains($log->description, 'Connexion')) {
                                        $actionType = 'connexion';
                                        $actionIcon = 'fa-sign-in-alt';
                                    } elseif(str_contains($log->description, 'crée') || str_contains($log->description, 'Création')) {
                                        $actionType = 'creation';
                                        $actionIcon = 'fa-plus-circle';
                                    } elseif(str_contains($log->description, 'modifie') || str_contains($log->description, 'Modification')) {
                                        $actionType = 'modification';
                                        $actionIcon = 'fa-edit';
                                    } elseif(str_contains($log->description, 'supprime') || str_contains($log->description, 'Suppression')) {
                                        $actionType = 'suppression';
                                        $actionIcon = 'fa-trash-alt';
                                    } elseif(str_contains($log->description, 'paiement') || str_contains($log->description, 'Paiement')) {
                                        $actionType = 'paiement';
                                        $actionIcon = 'fa-credit-card';
                                    }
                                }
                            @endphp
                            <span class="action-badge action-{{ $actionType }}">
                                <i class="fas {{ $actionIcon }}"></i>
                                @if(isset($log->description))
                                    {{ $log->description }}
                                @elseif(isset($log->payload))
                                    Session utilisateur
                                @else
                                    Connexion
                                @endif
                            </span>
                        </td>
                        <td class="log-ip">
                            <code>
                                @if(isset($log->ip_adresse))
                                    {{ $log->ip_adresse }}
                                @elseif(isset($log->ip_address))
                                    {{ $log->ip_address }}
                                @else
                                    -
                                @endif
                            </code>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Aucun log disponible</p>
                            <span>Les activités seront affichées ici</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($logs) && method_exists($logs, 'hasPages') && $logs->hasPages())
        <div class="pagination-container">
            {{ $logs->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>

@push('styles')
<style>
/* ============================================
   LOGS SYSTÈME - DESIGN MODERNE
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
    --gradient-primary: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
    --shadow: 0 1px 3px rgba(0,0,0,0.1);
    --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
    --transition: all 0.3s ease;
}

.logs-container {
    max-width: 1400px;
    margin: 0 auto;
}

/* Coins carrés */
.stats-header, .stat-item, .stat-icon, .filters-card, .data-card,
.search-box, .filter-select, .date-input, .btn-filter, .btn-reset,
.user-avatar, .action-badge, .btn-print, .pagination-container {
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
    box-shadow: var(--shadow);
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
.bg-orange { background: #fef3c7; color: #f59e0b; }
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

.btn-print {
    background: #f1f5f9;
    border: none;
    padding: 0.5rem 1.25rem;
    color: var(--gray);
    font-size: 0.813rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: var(--transition);
}

.btn-print:hover {
    background: #e2e8f0;
    color: var(--dark);
}

/* ==========================================
   FILTRES
   ========================================== */
.filters-card {
    background: var(--white);
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
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
    transition: var(--transition);
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

.date-input {
    position: relative;
}

.date-input i {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    font-size: 0.875rem;
}

.date-input input {
    padding: 0.625rem 0.75rem 0.625rem 2.25rem;
    border: 1px solid var(--border);
    font-size: 0.813rem;
    min-width: 140px;
}

.date-input input:focus {
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
    transition: var(--transition);
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
    transition: var(--transition);
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
    box-shadow: var(--shadow);
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

.data-table th i {
    margin-right: 0.375rem;
    color: var(--primary);
}

.data-table td {
    padding: 0.875rem 1rem;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}

.data-table tr:hover {
    background: var(--gray-light);
}

/* Log date */
.log-date {
    font-family: monospace;
    font-size: 0.75rem;
    color: var(--gray);
    white-space: nowrap;
}

.log-date i {
    margin-right: 0.375rem;
    color: var(--primary);
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

.user-info {
    display: flex;
    flex-direction: column;
}

.user-name {
    font-weight: 500;
    font-size: 0.875rem;
    color: var(--dark);
}

.user-role {
    font-size: 0.688rem;
    color: var(--gray);
}

/* Log email */
.log-email {
    font-size: 0.813rem;
    color: var(--dark);
}

/* Action badges */
.action-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.25rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.action-connexion {
    background: #e0e7ff;
    color: #4f46e5;
}

.action-creation {
    background: #d1fae5;
    color: #059669;
}

.action-modification {
    background: #fef3c7;
    color: #d97706;
}

.action-suppression {
    background: #fee2e2;
    color: #dc2626;
}

.action-paiement {
    background: #e0e7ff;
    color: #4f46e5;
}

.action-default {
    background: #f1f5f9;
    color: #64748b;
}

/* Log IP */
.log-ip code {
    font-family: monospace;
    font-size: 0.75rem;
    background: #f1f5f9;
    padding: 0.25rem 0.5rem;
    color: var(--dark);
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
    margin-bottom: 0.25rem;
    font-weight: 500;
}

.empty-state span {
    font-size: 0.75rem;
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
@media (max-width: 992px) {
    .stats-items {
        width: 100%;
        justify-content: space-between;
    }
}

@media (max-width: 768px) {
    .stats-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .stats-items {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .stat-item {
        justify-content: space-between;
        width: 100%;
    }
    
    .filters-form {
        flex-direction: column;
    }
    
    .search-box, .filter-select, .date-input, .btn-filter, .btn-reset {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .data-table th, .data-table td {
        padding: 0.625rem;
    }
    
    .user-cell {
        flex-direction: column;
        text-align: center;
    }
    
    .action-badge {
        white-space: normal;
        word-break: break-word;
    }
}
</style>
@endpush
@endsection