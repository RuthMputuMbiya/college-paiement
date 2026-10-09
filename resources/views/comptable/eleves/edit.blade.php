{{-- resources/views/comptable/eleves/edit.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Modifier un élève')
@section('page-title', 'Modifier un élève')
@section('page-subtitle', 'Modifier les informations de l\'élève')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="form-card">
        <div class="form-header">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div>
                    <h3>Modifier l'élève</h3>
                    <p>ID: {{ $eleve->id_eleve }} - {{ $eleve->prenom }} {{ $eleve->nom }}</p>
                </div>
            </div>
            <a href="{{ route('comptable.eleves.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('comptable.eleves.update', $eleve->id_eleve) }}" class="form-container" id="eleveForm">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <!-- Colonne gauche - Informations élève -->
                <div class="form-column">
                    <div class="section-title">
                        <div class="title-icon"><i class="fas fa-child"></i></div>
                        <div>
                            <h4>Informations de l'élève</h4>
                            <p>Données personnelles de l'élève</p>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-user"></i> Nom
                            </label>
                            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" 
                                   value="{{ old('nom', $eleve->nom) }}" placeholder="Nom de l'élève" required>
                            @error('nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-user"></i> Prénom
                            </label>
                            <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" 
                                   value="{{ old('prenom', $eleve->prenom) }}" placeholder="Prénom de l'élève" required>
                            @error('prenom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-envelope"></i> Email (connexion élève)
                        </label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $eleve->email) }}" placeholder="eleve@college-ndg.cd" required>
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nouveau mot de passe -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock"></i> Nouveau mot de passe
                        </label>
                        <div class="password-input">
                            <input type="password" name="mot_de_passe" id="password" class="form-control" placeholder="••••••••">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="form-hint">
                            <i class="fas fa-info-circle"></i> Laisser vide pour conserver l'ancien mot de passe
                        </small>
                        @error('mot_de_passe') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <!-- Confirmation du mot de passe -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-check-circle"></i> Confirmer le mot de passe
                        </label>
                        <div class="password-input">
                            <input type="password" name="mot_de_passe_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••">
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordMatchError" class="invalid-feedback" style="display: none;">
                            <i class="fas fa-times-circle"></i> Les mots de passe ne correspondent pas
                        </div>
                        <div id="passwordMatchSuccess" class="valid-feedback" style="display: none;">
                            <i class="fas fa-check-circle"></i> Les mots de passe correspondent
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-calendar"></i> Date de naissance
                            </label>
                            <input type="date" name="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror" 
                                   value="{{ old('date_naissance', $eleve->date_naissance) }}" required>
                            @error('date_naissance') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-venus-mars"></i> Sexe
                            </label>
                            <div class="sexe-selector">
                                <label class="sexe-option">
                                    <input type="radio" name="sexe" value="M" {{ old('sexe', $eleve->sexe) == 'M' ? 'checked' : '' }} required>
                                    <div class="sexe-card sexe-masculin">
                                        <i class="fas fa-mars"></i>
                                        <span>Masculin</span>
                                    </div>
                                </label>
                                <label class="sexe-option">
                                    <input type="radio" name="sexe" value="F" {{ old('sexe', $eleve->sexe) == 'F' ? 'checked' : '' }}>
                                    <div class="sexe-card sexe-feminin">
                                        <i class="fas fa-venus"></i>
                                        <span>Féminin</span>
                                    </div>
                                </label>
                            </div>
                            @error('sexe') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-building"></i> Classe
                        </label>
                        <select name="classe_id" class="form-control @error('classe_id') is-invalid @enderror" required>
                            <option value="">Sélectionner une classe</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id_classe }}" {{ old('classe_id', $eleve->classe_id) == $classe->id_classe ? 'selected' : '' }}>
                                    {{ $classe->nom_classe }} - {{ $classe->niveau }} ({{ $classe->effectif }}/{{ $classe->capacite }})
                                </option>
                            @endforeach
                        </select>
                        @error('classe_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-circle"></i> Statut
                        </label>
                        <div class="statut-selector">
                            <label class="statut-option">
                                <input type="radio" name="statut" value="inscrit" {{ old('statut', $eleve->statut) == 'inscrit' ? 'checked' : '' }}>
                                <span class="statut-badge statut-inscrit">
                                    <i class="fas fa-check-circle"></i> Inscrit
                                </span>
                            </label>
                            <label class="statut-option">
                                <input type="radio" name="statut" value="exclu" {{ old('statut', $eleve->statut) == 'exclu' ? 'checked' : '' }}>
                                <span class="statut-badge statut-exclu">
                                    <i class="fas fa-ban"></i> Exclu
                                </span>
                            </label>
                            <label class="statut-option">
                                <input type="radio" name="statut" value="transfere" {{ old('statut', $eleve->statut) == 'transfere' ? 'checked' : '' }}>
                                <span class="statut-badge statut-transfere">
                                    <i class="fas fa-exchange-alt"></i> Transféré
                                </span>
                            </label>
                        </div>
                        @error('statut') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Colonne droite - Informations parent -->
                <div class="form-column">
                    <div class="section-title">
                        <div class="title-icon"><i class="fas fa-users"></i></div>
                        <div>
                            <h4>Informations du parent</h4>
                            <p>Coordonnées du parent ou tuteur</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-user"></i> Nom du parent
                        </label>
                        <input type="text" name="nom_parent" class="form-control @error('nom_parent') is-invalid @enderror" 
                               value="{{ old('nom_parent', $eleve->nom_parent) }}" placeholder="Nom complet du parent" required>
                        @error('nom_parent') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-envelope"></i> Email du parent
                        </label>
                        <input type="email" name="email_parent" class="form-control @error('email_parent') is-invalid @enderror" 
                               value="{{ old('email_parent', $eleve->email_parent) }}" placeholder="parent@email.com" required>
                        <small class="form-hint">
                            <i class="fas fa-info-circle"></i> Un compte parent sera créé automatiquement si inexistant
                        </small>
                        @error('email_parent') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-phone"></i> Téléphone du parent
                        </label>
                        <div class="phone-input">
                            <span class="phone-prefix">+243</span>
                            <input type="tel" name="telephone_parent" class="form-control @error('telephone_parent') is-invalid @enderror" 
                                   value="{{ old('telephone_parent', $eleve->telephone_parent) }}" placeholder="XXX XXX XXX" required>
                        </div>
                        @error('telephone_parent') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="info-stats">
                        <div class="stat-item">
                            <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                            <div class="stat-content">
                                <span class="stat-label">Date d'inscription</span>
                                <span class="stat-value">{{ $eleve->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon"><i class="fas fa-edit"></i></div>
                            <div class="stat-content">
                                <span class="stat-label">Dernière modification</span>
                                <span class="stat-value">{{ $eleve->updated_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
                            <div class="stat-content">
                                <span class="stat-label">Total payé</span>
                                <span class="stat-value">{{ number_format($eleve->paiements->where('statut', 'valide')->sum('montant'), 0, ',', ' ') }} FC</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-box">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>À savoir</strong><br>
                            L'élève recevra ses identifiants de connexion par email.<br>
                            Un compte parent sera automatiquement créé si l'email n'existe pas déjà.
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i> Mettre à jour
                </button>
                <a href="{{ route('comptable.eleves.show', $eleve->id_eleve) }}" class="btn-outline">
                    <i class="fas fa-eye"></i> Voir les détails
                </a>
                <a href="{{ route('comptable.eleves.index') }}" class="btn-outline">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>

</div>

@push('styles')
<style>
    /* ========================================== */
    /* FORM CARD */
    /* ========================================== */
    .form-card {
        background: white;
        border-radius: 0px;
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
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }
    .header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .header-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 22px;
    }
    .header-left h3 {
        font-size: 18px;
        font-weight: 700;
        margin: 0;
        color: #1e293b;
    }
    .header-left p {
        font-size: 13px;
        margin: 3px 0 0 0;
        color: #64748b;
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

    /* ========================================== */
    /* FORM CONTENT */
    /* ========================================== */
    .form-container {
        padding: 25px;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }
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
        margin-right: 8px;
        color: #10b981;
        width: 18px;
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
        border-color: #10b981;
        box-shadow: 0 0 0 2px rgba(16,185,129,0.1);
    }
    .invalid-feedback {
        display: block;
        color: #ef4444;
        font-size: 11px;
        margin-top: 5px;
    }
    .valid-feedback {
        display: block;
        color: #10b981;
        font-size: 11px;
        margin-top: 5px;
    }
    .form-hint {
        display: block;
        font-size: 11px;
        color: #64748b;
        margin-top: 5px;
    }
    .form-hint i {
        margin-right: 4px;
    }

    /* ========================================== */
    /* SECTION TITLE */
    /* ========================================== */
    .section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e2e8f0;
    }
    .title-icon {
        width: 40px;
        height: 40px;
        background: #ecfdf5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
        font-size: 18px;
    }
    .section-title h4 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        color: #1e293b;
    }
    .section-title p {
        font-size: 11px;
        margin: 2px 0 0 0;
        color: #64748b;
    }

    /* ========================================== */
    /* FORM ROW */
    /* ========================================== */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 5px;
    }

    /* ========================================== */
    /* PASSWORD INPUT */
    /* ========================================== */
    .password-input {
        position: relative;
        display: flex;
        align-items: center;
    }
    .password-input input {
        flex: 1;
        padding-right: 45px;
    }
    .password-toggle {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        color: #94a3b8;
        cursor: pointer;
    }

    /* ========================================== */
    /* SEXE SELECTOR */
    /* ========================================== */
    .sexe-selector {
        display: flex;
        gap: 15px;
    }
    .sexe-option {
        flex: 1;
        cursor: pointer;
    }
    .sexe-option input {
        display: none;
    }
    .sexe-option input:checked + .sexe-card {
        border-color: #10b981;
        background: #ecfdf5;
        transform: translateY(-2px);
    }
    .sexe-card {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s;
        cursor: pointer;
    }
    .sexe-card i {
        font-size: 18px;
    }
    .sexe-card span {
        font-weight: 600;
        font-size: 14px;
    }
    .sexe-masculin i { color: #3b82f6; }
    .sexe-masculin span { color: #3b82f6; }
    .sexe-feminin i { color: #ec4899; }
    .sexe-feminin span { color: #ec4899; }

    /* ========================================== */
    /* STATUT SELECTOR */
    /* ========================================== */
    .statut-selector {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    .statut-option {
        cursor: pointer;
    }
    .statut-option input {
        display: none;
    }
    .statut-option input:checked + .statut-badge {
        opacity: 1;
        transform: scale(1.02);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .statut-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 18px;
        font-size: 13px;
        font-weight: 500;
        opacity: 0.6;
        transition: all 0.3s;
        cursor: pointer;
    }
    .statut-inscrit {
        background: #d1fae5;
        color: #059669;
    }
    .statut-exclu {
        background: #fee2e2;
        color: #dc2626;
    }
    .statut-transfere {
        background: #fef3c7;
        color: #d97706;
    }

    /* ========================================== */
    /* PHONE INPUT */
    /* ========================================== */
    .phone-input {
        display: flex;
        align-items: center;
    }
    .phone-prefix {
        background: #f1f5f9;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-right: none;
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
    }
    .phone-input .form-control {
        border-left: none;
    }

    /* ========================================== */
    /* INFO STATS */
    /* ========================================== */
    .info-stats {
        background: #f8fafc;
        padding: 15px;
        margin: 20px 0;
        border: 1px solid #e2e8f0;
    }
    .stat-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #e2e8f0;
    }
    .stat-item:last-child {
        border-bottom: none;
    }
    .stat-icon {
        width: 35px;
        height: 35px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
        font-size: 16px;
    }
    .stat-content {
        flex: 1;
    }
    .stat-label {
        display: block;
        font-size: 10px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-value {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    /* ========================================== */
    /* INFO BOX */
    /* ========================================== */
    .info-box {
        background: #eff6ff;
        padding: 15px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        border-left: 3px solid #3b82f6;
        margin-top: 20px;
    }
    .info-box i {
        color: #3b82f6;
        font-size: 18px;
    }
    .info-box div {
        font-size: 12px;
        color: #1e293b;
        line-height: 1.5;
    }
    .info-box strong {
        display: block;
        margin-bottom: 5px;
    }

    /* ========================================== */
    /* FORM ACTIONS */
    /* ========================================== */
    .form-actions {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 15px;
        justify-content: flex-end;
    }
    .btn-primary {
        background: #10b981;
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
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(16,185,129,0.3);
    }
    .btn-outline {
        background: transparent;
        border: 1px solid #e2e8f0;
        padding: 11px 27px;
        color: #64748b;
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .btn-outline:hover {
        border-color: #ef4444;
        color: #ef4444;
    }

    /* ========================================== */
    /* RESPONSIVE */
    /* ========================================== */
    @media (max-width: 992px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
    @media (max-width: 768px) {
        .form-header {
            flex-direction: column;
            text-align: center;
        }
        .header-left {
            flex-direction: column;
            text-align: center;
        }
        .sexe-selector, .statut-selector {
            flex-direction: column;
        }
        .form-actions {
            flex-direction: column;
        }
        .btn-primary, .btn-outline {
            justify-content: center;
        }
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

    // Validation de la confirmation du mot de passe
    const passwordInput = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirmation');
    const passwordMatchError = document.getElementById('passwordMatchError');
    const passwordMatchSuccess = document.getElementById('passwordMatchSuccess');

    function validatePasswordMatch() {
        if (passwordConfirm.value === '') {
            passwordMatchError.style.display = 'none';
            passwordMatchSuccess.style.display = 'none';
            passwordConfirm.classList.remove('is-invalid', 'is-valid');
            return false;
        }
        
        if (passwordInput.value !== passwordConfirm.value) {
            passwordMatchError.style.display = 'block';
            passwordMatchSuccess.style.display = 'none';
            passwordConfirm.classList.add('is-invalid');
            passwordConfirm.classList.remove('is-valid');
            return false;
        } else {
            passwordMatchError.style.display = 'none';
            passwordMatchSuccess.style.display = 'block';
            passwordConfirm.classList.remove('is-invalid');
            passwordConfirm.classList.add('is-valid');
            return true;
        }
    }

    passwordInput.addEventListener('input', validatePasswordMatch);
    passwordConfirm.addEventListener('input', validatePasswordMatch);

    // Validation avant soumission
    const eleveForm = document.getElementById('eleveForm');
    eleveForm.addEventListener('submit', function(e) {
        if (passwordInput.value !== '' && passwordConfirm.value === '') {
            e.preventDefault();
            passwordMatchError.style.display = 'block';
            passwordMatchError.innerHTML = '<i class="fas fa-times-circle"></i> Veuillez confirmer le mot de passe';
            passwordMatchError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } else if (passwordInput.value !== '' && passwordInput.value !== passwordConfirm.value) {
            e.preventDefault();
            passwordMatchError.style.display = 'block';
            passwordMatchError.innerHTML = '<i class="fas fa-times-circle"></i> Les mots de passe ne correspondent pas';
            passwordMatchError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>
@endpush
@endsection