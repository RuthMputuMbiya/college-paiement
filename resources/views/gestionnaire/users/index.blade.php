{{-- resources/views/gestionnaire/users/index.blade.php --}}
@extends('layouts.gestionnaire')

@section('title', 'Utilisateurs')
@section('page-title', 'Gestion des utilisateurs')
@section('page-subtitle', 'Liste des utilisateurs du système')

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-users"></i> Liste des utilisateurs</h3>
        <a href="{{ route('gestionnaire.users.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Nouvel utilisateur
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
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
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->telephone ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $user->role == 'gestionnaire_systeme' ? 'badge-info' : ($user->role == 'comptable' ? 'badge-success' : 'badge-warning') }}">
                                {{ $user->role_label }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $user->statut == 'actif' ? 'badge-success' : 'badge-danger' }}">
                                {{ $user->statut }}
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
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px;">
                            <i class="fas fa-users-slash fa-3x mb-3" style="color: #94a3b8;"></i>
                            <p>Aucun utilisateur trouvé</p>
                            <a href="{{ route('gestionnaire.users.create') }}" class="btn-primary mt-2">Ajouter un utilisateur</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer">
        {{ $users->links() }}
    </div>
    @endif
</div>

<style>
    .badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; font-size: 11px; font-weight: 500; }
    .badge-success { background: #d1fae5; color: #059669; }
    .badge-danger { background: #fee2e2; color: #dc2626; }
    .badge-warning { background: #fef3c7; color: #d97706; }
    .badge-info { background: #e0e7ff; color: #4f46e5; }
    .action-buttons { display: flex; gap: 8px; }
    .action-btn { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; background: #f1f5f9; color: #64748b; border: none; cursor: pointer; transition: all 0.2s; }
    .action-btn.view:hover { background: #3b82f6; color: white; }
    .action-btn.edit:hover { background: #f59e0b; color: white; }
    .action-btn.delete:hover { background: #ef4444; color: white; }
    .btn-primary { background: #4f46e5; color: white; padding: 8px 20px; text-decoration: none; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer; transition: all 0.3s; }
    .btn-primary:hover { background: #4338ca; transform: translateY(-2px); }
</style>
@endsection