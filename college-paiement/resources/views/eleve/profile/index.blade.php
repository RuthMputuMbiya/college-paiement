{{-- resources/views/eleve/profile/index.blade.php --}}
@extends('layouts.eleve')

@section('title', 'Mon profil')
@section('page-title', 'Mon profil')
@section('page-subtitle', 'Consultez et modifiez vos informations personnelles')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="row g-4">
        <!-- Colonne gauche - Carte de profil -->
        <div class="col-lg-4">
            <div class="profile-card">
                <div class="profile-avatar text-center">
                    <div class="avatar-circle" style="background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);">
                        {{ strtoupper(substr($eleve->prenom, 0, 1)) }}{{ strtoupper(substr($eleve->nom, 0, 1)) }}
                    </div>
                    <h3 class="profile-name">{{ $eleve->prenom }} {{ $eleve->nom }}</h3>
                    <p class="profile-role">
                        <i class="fas fa-graduation-cap"></i> Élève
                    </p>
                    <p class="profile-class">
                        <i class="fas fa-building"></i> {{ $eleve->classe->nom_classe ?? 'N/A' }}
                    </p>
                </div>
                
                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ $stats['nb_paiements'] ?? 0 }}</div>
                        <div class="stat-label">Paiements effectués</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ number_format($stats['total_paye'] ?? 0, 0, ',', ' ') }} FC</div>
                        <div class="stat-label">Total payé</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $stats['taux_paiement'] ?? 0 }}%</div>
                        <div class="stat-label">Taux de paiement</div>
                    </div>
                </div>

                <div class="profile-info-item">
                    <div class="info-icon"><i class="fas fa-envelope"></i></div>
                    <div class="info-content">
                        <span class="info-label">Email</span>
                        <span class="info-value">{{ $eleve->email }}</span>
                    </div>
                </div>

                <div class="profile-info-item">
                    <div class="info-icon"><i class="fas fa-calendar-alt"></i></div>
                    <div class="info-content">
                        <span class="info-label">Date de naissance</span>
                        <span class="info-value">{{ $eleve->date_naissance->format('d/m/Y') }}</span>
                    </div>
                </div>

                <div class="profile-info-item">
                    <div class="info-icon"><i class="fas fa-venus-mars"></i></div>
                    <div class="info-content">
                        <span class="info-label">Sexe</span>
                        <span class="info-value">{{ $eleve->sexe == 'M' ? 'Masculin' : 'Féminin' }}</span>
                    </div>
                </div>

                <div class="profile-info-item">
                    <div class="info-icon"><i class="fas fa-clock"></i></div>
                    <div class="info-content">
                        <span class="info-label">Membre depuis</span>
                        <span class="info-value">{{ $eleve->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne droite - Formulaires -->
        <div class="col-lg-8">
            <!-- Informations scolaires -->
            <div class="form-card mb-4">
                <div class="form-header">
                    <div class="header-left">
                        <i class="fas fa-graduation-cap"></i>
                        <div>
                            <h3>Informations scolaires</h3>
                            <p>Détails de votre scolarité</p>
                        </div>
                    </div>
                </div>
                <div class="form-body">
                    <div class="info-row">
                        <div class="info-label">Classe</div>
                        <div class="info-value">{{ $eleve->classe->nom_classe ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Niveau</div>
                        <div class="info-value">{{ $eleve->classe->niveau ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Année scolaire</div>
                        <div class="info-value">{{ $eleve->classe->annee_scolaire ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Statut</div>
                        <div class="info-value">
                            <span class="status-badge status-{{ $eleve->statut }}">
                                {{ $eleve->statut == 'inscrit' ? 'Inscrit' : ($eleve->statut == 'exclu' ? 'Exclu' : 'Transféré') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations parent -->
            <div class="form-card mb-4">
                <div class="form-header">
                    <div class="header-left">
                        <i class="fas fa-users"></i>
                        <div>
                            <h3>Informations parent</h3>
                            <p>Coordonnées de votre parent/tuteur</p>
                        </div>
                    </div>
                </div>
                <div class="form-body">
                    <div class="info-row">
                        <div class="info-label">Nom du parent</div>
                        <div class="info-value">{{ $eleve->nom_parent ?? 'Non renseigné' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $eleve->email_parent ?? 'Non renseigné' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Téléphone</div>
                        <div class="info-value">{{ $eleve->telephone_parent ?? 'Non renseigné' }}</div>
                    </div>
                </div>
            </div>

            <!-- Changement de mot de passe -->
            <div class="form-card">
                <div class="form-header">
                    <div class="header-left">
                        <i class="fas fa-key"></i>
                        <div>
                            <h3>Changer le mot de passe</h3>
                            <p>Modifiez votre mot de passe de connexion</p>
                        </div>
                    </div>
                </div>
                <div class="form-body">
                    <form method="POST" action="{{ route('eleve.profile.update-password') }}" id="passwordForm">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-lock"></i> Nouveau mot de passe
                            </label>
                            <div class="password-input">
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="password-strength mt-2">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                                <div class="strength-text" id="strengthText">Entrez un mot de passe sécurisé</div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
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
                            <div id="passwordMatchError" class="invalid-feedback" style="display: none;">
                                Les mots de passe ne correspondent pas
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-primary" id="submitBtn">
                                <i class="fas fa-save"></i> Changer le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@push('styles')
<style>
    /* Layout */
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

    /* Profile Card */
    .profile-card {
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .profile-avatar {
        padding: 30px 20px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e2e8f0;
    }
    .avatar-circle {
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
    .profile-name {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 5px 0;
        color: #1e293b;
    }
    .profile-role, .profile-class {
        font-size: 13px;
        color: #64748b;
        margin: 5px 0;
    }
    .profile-role i, .profile-class i {
        margin-right: 5px;
        color: #ea580c;
    }

    .profile-stats {
        display: flex;
        padding: 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    .stat-item {
        flex: 1;
        text-align: center;
    }
    .stat-value {
        font-size: 18px;
        font-weight: 700;
        color: #ea580c;
    }
    .stat-label {
        font-size: 11px;
        color: #64748b;
        margin-top: 5px;
    }

    .profile-info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 20px;
        border-bottom: 1px solid #f1f5f9;
    }
    .info-icon {
        width: 35px;
        height: 35px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ea580c;
    }
    .info-content {
        flex: 1;
    }
    .info-label {
        display: block;
        font-size: 10px;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-value {
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
    }

    /* Form Card */
    .form-card {
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .form-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
        background: #f8fafc;
    }
    .header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .header-left i {
        font-size: 22px;
        color: #ea580c;
    }
    .header-left h3 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        color: #1e293b;
    }
    .header-left p {
        font-size: 12px;
        margin: 3px 0 0 0;
        color: #64748b;
    }

    .form-body {
        padding: 22px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .info-label {
        font-size: 13px;
        color: #64748b;
    }
    .info-value {
        font-size: 13px;
        font-weight: 500;
        color: #1e293b;
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

    /* Form Group */
    .form-group {
        margin-bottom: 20px;
    }
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 13px;
        color: #1e293b;
    }
    .form-label.required::after {
        content: '*';
        color: #ef4444;
        margin-left: 4px;
    }
    .form-label i {
        margin-right: 6px;
        color: #64748b;
        width: 18px;
    }

    .password-input {
        position: relative;
        display: flex;
        align-items: center;
    }
    .password-input input {
        flex: 1;
        padding-right: 45px;
    }
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
    .form-control.is-invalid {
        border-color: #ef4444;
    }
    .password-toggle {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
    }
    .invalid-feedback {
        display: block;
        color: #ef4444;
        font-size: 11px;
        margin-top: 5px;
    }

    /* Password Strength */
    .password-strength {
        margin-top: 8px;
    }
    .strength-bar {
        height: 4px;
        background: #e2e8f0;
        margin-bottom: 5px;
    }
    .strength-fill {
        height: 100%;
        width: 0%;
        transition: all 0.3s;
    }
    .strength-text {
        font-size: 10px;
        color: #64748b;
    }

    /* Form Actions */
    .form-actions {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
    }
    .btn-primary {
        background: #ea580c;
        border: none;
        padding: 10px 25px;
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

    /* Responsive */
    @media (max-width: 992px) {
        .col-lg-4, .col-lg-8 {
            width: 100%;
        }
    }
    @media (max-width: 768px) {
        .profile-stats {
            flex-direction: column;
            gap: 15px;
        }
        .info-row {
            flex-direction: column;
            gap: 5px;
        }
        .form-actions {
            justify-content: center;
        }
        .btn-primary {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Toggle password visibility
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

    // Password strength checker
    const passwordInput = document.getElementById('password');
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');

    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        
        if (password.length === 0) {
            strengthFill.style.width = '0%';
            strengthText.innerHTML = 'Entrez un mot de passe sécurisé';
            strengthText.style.color = '#64748b';
            strengthFill.style.backgroundColor = '#e2e8f0';
            return;
        }
        
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/)) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;
        
        if (strength <= 2) {
            strengthFill.style.backgroundColor = '#ef4444';
            strengthText.style.color = '#ef4444';
            strengthText.innerHTML = 'Mot de passe : Faible';
        } else if (strength <= 4) {
            strengthFill.style.backgroundColor = '#f59e0b';
            strengthText.style.color = '#f59e0b';
            strengthText.innerHTML = 'Mot de passe : Moyen';
        } else {
            strengthFill.style.backgroundColor = '#10b981';
            strengthText.style.color = '#10b981';
            strengthText.innerHTML = 'Mot de passe : Fort';
        }
        
        strengthFill.style.width = (strength / 5 * 100) + '%';
    });

    // Password confirmation validation
    const passwordConfirm = document.getElementById('password_confirmation');
    const passwordMatchError = document.getElementById('passwordMatchError');
    const submitBtn = document.getElementById('submitBtn');

    function validatePasswordMatch() {
        if (passwordInput.value !== passwordConfirm.value && passwordConfirm.value !== '') {
            passwordMatchError.style.display = 'block';
            passwordConfirm.classList.add('is-invalid');
            return false;
        } else {
            passwordMatchError.style.display = 'none';
            passwordConfirm.classList.remove('is-invalid');
            return true;
        }
    }

    passwordInput.addEventListener('input', validatePasswordMatch);
    passwordConfirm.addEventListener('input', validatePasswordMatch);

    // Form validation before submit
    const passwordForm = document.getElementById('passwordForm');
    passwordForm.addEventListener('submit', function(e) {
        if (!validatePasswordMatch()) {
            e.preventDefault();
            passwordMatchError.style.display = 'block';
        }
    });
</script>
@endpush
@endsection