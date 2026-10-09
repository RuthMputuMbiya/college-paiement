{{-- resources/views/parent/profile/edit.blade.php --}}
@extends('layouts.parent')

@section('title', 'Mon profil')
@section('page-title', 'Mon profil')
@section('page-subtitle', 'Modifiez vos informations personnelles')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="row g-4">
        <!-- Colonne gauche - Carte de profil -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="user-avatar-large" style="margin: 0 auto 20px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <h3 class="profile-name">{{ Auth::user()->name }}</h3>
                    <p class="profile-role">
                        <i class="fas fa-users"></i> Parent d'élève
                    </p>
                    <p class="profile-status">
                        <span class="badge {{ Auth::user()->statut == 'actif' ? 'badge-success' : 'badge-danger' }}">
                            <i class="fas {{ Auth::user()->statut == 'actif' ? 'fa-check-circle' : 'fa-ban' }}"></i>
                            {{ Auth::user()->statut == 'actif' ? 'Compte actif' : 'Compte inactif' }}
                        </span>
                    </p>
                </div>
                <div class="card-footer">
                    <div class="stats-mini">
                        <div class="stat-mini">
                            <div class="stat-mini-value">{{ $stats['total_enfants'] ?? 0 }}</div>
                            <div class="stat-mini-label">Enfants</div>
                        </div>
                        <div class="stat-mini">
                            <div class="stat-mini-value">{{ number_format($stats['total_paye'] ?? 0, 0, ',', ' ') }} FC</div>
                            <div class="stat-mini-label">Total payé</div>
                        </div>
                        <div class="stat-mini">
                            <div class="stat-mini-value">{{ $stats['taux_paiement'] ?? 0 }}%</div>
                            <div class="stat-mini-label">Taux</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h3><i class="fas fa-info-circle"></i> Informations</h3>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <div class="info-content">
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-clock"></i></div>
                        <div class="info-content">
                            <span class="info-label">Membre depuis</span>
                            <span class="info-value">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-clock"></i></div>
                        <div class="info-content">
                            <span class="info-label">Dernière connexion</span>
                            <span class="info-value">{{ Auth::user()->last_login_at ? Auth::user()->last_login_at->format('d/m/Y') : 'Jamais' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne droite - Formulaires -->
        <div class="col-lg-8">
            <!-- Formulaire informations personnelles -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3><i class="fas fa-user-edit"></i> Informations personnelles</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('parent.profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label class="form-label required">Nom complet</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Téléphone</label>
                            <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror" 
                                   value="{{ old('telephone', Auth::user()->telephone) }}" required>
                            @error('telephone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Adresse</label>
                            <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror" 
                                   value="{{ old('adresse', Auth::user()->adresse) }}">
                            @error('adresse') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Profession</label>
                            <input type="text" name="profession" class="form-control @error('profession') is-invalid @enderror" 
                                   value="{{ old('profession', Auth::user()->profession) }}">
                            @error('profession') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                            <a href="{{ route('parent.dashboard') }}" class="btn-outline">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Formulaire changement mot de passe -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-key"></i> Changer le mot de passe</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('parent.profile.password') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label class="form-label required">Mot de passe actuel</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Nouveau mot de passe</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i> Changer le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }
    .col-lg-4, .col-lg-8 {
        padding: 0 10px;
    }
    .col-lg-4 { width: 33.333%; }
    .col-lg-8 { width: 66.666%; }

    .user-avatar-large {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #6b21a5 0%, #7e22ce 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 700;
        color: white;
        margin: 0 auto;
    }
    .profile-name {
        font-size: 18px;
        font-weight: 700;
        margin: 10px 0 5px;
    }
    .profile-role {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 10px;
    }
    .stats-mini {
        display: flex;
        justify-content: space-around;
        text-align: center;
    }
    .stat-mini-value {
        font-size: 18px;
        font-weight: 700;
        color: #6b21a5;
    }
    .stat-mini-label {
        font-size: 10px;
        color: #64748b;
    }
    .info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #e2e8f0;
    }
    .info-item:last-child {
        border-bottom: none;
    }
    .info-icon {
        width: 35px;
        height: 35px;
        background: #f3e8ff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b21a5;
    }
    .info-content {
        flex: 1;
    }
    .info-label {
        display: block;
        font-size: 10px;
        color: #94a3b8;
        text-transform: uppercase;
    }
    .info-value {
        font-size: 13px;
        font-weight: 500;
        color: #1e293b;
    }

    .form-group { margin-bottom: 20px; }
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 13px;
        color: #1e293b;
    }
    .form-label.required::after { content: '*'; color: #ef4444; margin-left: 4px; }
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e2e8f0;
        font-size: 14px;
        transition: all 0.3s;
    }
    .form-control:focus {
        outline: none;
        border-color: #6b21a5;
        box-shadow: 0 0 0 2px rgba(107,33,165,0.1);
    }
    .invalid-feedback {
        display: block;
        color: #ef4444;
        font-size: 11px;
        margin-top: 5px;
    }
    .form-actions {
        margin-top: 20px;
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }

    @media (max-width: 992px) {
        .col-lg-4, .col-lg-8 { width: 100%; }
    }
    @media (max-width: 768px) {
        .form-actions { flex-direction: column; }
        .btn-primary, .btn-outline { justify-content: center; width: 100%; }
        .stats-mini { flex-direction: column; gap: 10px; }
    }
</style>
@endsection