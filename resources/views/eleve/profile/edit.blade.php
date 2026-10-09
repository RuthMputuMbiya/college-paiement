{{-- resources/views/eleve/profile/edit.blade.php --}}
@extends('layouts.eleve')

@section('title', 'Mon profil')
@section('page-title', 'Mon profil')
@section('page-subtitle', 'Consultez et modifiez vos informations')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="form-card">
        <div class="form-header">
            <div class="header-left">
                <i class="fas fa-user-circle"></i>
                <div>
                    <h3>Informations personnelles</h3>
                    <p>Consultez vos informations personnelles</p>
                </div>
            </div>
            <a href="{{ route('eleve.dashboard') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        <div class="profile-info">
            <div class="profile-avatar">
                <div class="avatar-large">
                    {{ strtoupper(substr($eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleve->nom, 0, 1)) }}
                </div>
                <h3>{{ $eleve->prenom }} {{ $eleve->nom }}</h3>
                <p>Élève - {{ $eleve->classe->nom_classe ?? 'N/A' }}</p>
            </div>

            <div class="info-grid">
                <div class="info-card">
                    <h4><i class="fas fa-child"></i> Informations personnelles</h4>
                    <div class="info-row">
                        <span class="info-label">Nom complet</span>
                        <span class="info-value">{{ $eleve->prenom }} {{ $eleve->nom }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Date de naissance</span>
                        <span class="info-value">{{ $eleve->date_naissance->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Sexe</span>
                        <span class="info-value">{{ $eleve->sexe == 'M' ? 'Masculin' : 'Féminin' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $eleve->email }}</span>
                    </div>
                </div>

                <div class="info-card">
                    <h4><i class="fas fa-graduation-cap"></i> Informations scolaires</h4>
                    <div class="info-row">
                        <span class="info-label">Classe</span>
                        <span class="info-value">{{ $eleve->classe->nom_classe ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Niveau</span>
                        <span class="info-value">{{ $eleve->classe->niveau ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Année scolaire</span>
                        <span class="info-value">{{ $eleve->classe->annee_scolaire ?? 'N/A' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Statut</span>
                        <span class="info-value">
                            <span class="status-badge status-{{ $eleve->statut }}">
                                {{ $eleve->statut == 'inscrit' ? 'Inscrit' : ($eleve->statut == 'exclu' ? 'Exclu' : 'Transféré') }}
                            </span>
                        </span>
                    </div>
                </div>

                <div class="info-card">
                    <h4><i class="fas fa-users"></i> Informations parent</h4>
                    <div class="info-row">
                        <span class="info-label">Nom du parent</span>
                        <span class="info-value">{{ $eleve->nom_parent ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $eleve->email_parent ?? 'Non renseigné' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Téléphone</span>
                        <span class="info-value">{{ $eleve->telephone_parent ?? 'Non renseigné' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de changement de mot de passe -->
    <div class="form-card mt-4">
        <div class="form-header">
            <div class="header-left">
                <i class="fas fa-key"></i>
                <div>
                    <h3>Changer le mot de passe</h3>
                    <p>Modifiez votre mot de passe de connexion</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('eleve.profile.update-password') }}" class="form-container">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label required">
                        <i class="fas fa-lock"></i> Nouveau mot de passe
                    </label>
                    <div class="password-input">
                        <input type="password" name="password" id="password" class="form-control" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label required">
                        <i class="fas fa-check-circle"></i> Confirmer le mot de passe
                    </label>
                    <div class="password-input">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Changer le mot de passe
                </button>
            </div>
        </form>
    </div>

</div>

@push('styles')
<style>
    .form-card {
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .form-header {
        padding: 20px 25px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        background: #f8fafc;
    }
    .form-header .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .form-header .header-left i {
        font-size: 24px;
        color: #ea580c;
    }
    .form-header .header-left h3 {
        font-size: 18px;
        font-weight: 700;
        margin: 0;
        color: #1e293b;
    }
    .form-header .header-left p {
        font-size: 13px;
        margin: 3px 0 0 0;
        color: #64748b;
    }

    .profile-info { padding: 25px; }
    .profile-avatar {
        text-align: center;
        margin-bottom: 30px;
    }
    .avatar-large {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 36px;
        font-weight: 700;
        color: white;
    }
    .profile-avatar h3 { font-size: 20px; font-weight: 700; color: #1e293b; margin-bottom: 5px; }
    .profile-avatar p { color: #64748b; }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 25px;
    }
    .info-card { border: 1px solid #e2e8f0; padding: 20px; }
    .info-card h4 {
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 15px 0;
        padding-bottom: 12px;
        border-bottom: 2px solid #e2e8f0;
        color: #1e293b;
    }
    .info-card h4 i { margin-right: 8px; color: #ea580c; }
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .info-label { font-size: 13px; color: #64748b; }
    .info-value { font-size: 13px; font-weight: 500; color: #1e293b; }

    .form-container { padding: 25px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
    .form-group { margin-bottom: 20px; }
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 13px;
        color: #1e293b;
    }
    .form-label.required::after { content: '*'; color: #ef4444; margin-left: 4px; }
    .form-label i { margin-right: 6px; color: #64748b; width: 18px; }
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        font-size: 14px;
        transition: all 0.3s;
        background: white;
    }
    .form-control:focus {
        outline: none;
        border-color: #ea580c;
        box-shadow: 0 0 0 2px rgba(234,88,12,0.1);
    }
    .password-input { position: relative; display: flex; align-items: center; }
    .password-input input { flex: 1; padding-right: 45px; }
    .password-toggle {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
    }

    .form-actions {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }
    .btn-primary {
        background: #ea580c;
        border: none;
        padding: 12px 28px;
        color: white;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-primary:hover {
        background: #c2410c;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(234,88,12,0.3);
    }
    .btn-secondary {
        background: #f1f5f9;
        border: none;
        padding: 10px 20px;
        color: #64748b;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .btn-secondary:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    @media (max-width: 768px) {
        .form-grid { grid-template-columns: 1fr; gap: 0; }
        .info-grid { grid-template-columns: 1fr; }
        .form-actions { flex-direction: column; }
        .btn-primary { justify-content: center; }
    }
</style>
@endpush

@push('scripts')
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.parentElement.querySelector('.password-toggle i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush
@endsection