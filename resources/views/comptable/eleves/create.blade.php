{{-- resources/views/comptable/eleves/create.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Ajouter un élève')
@section('page-title', 'Ajouter un élève')
@section('page-subtitle', 'Inscrire un nouvel élève')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="form-card">
        <div class="form-header">
            <div class="header-left">
                <i class="fas fa-user-plus"></i>
                <div>
                    <h3>Nouvel élève</h3>
                    <p>Remplissez toutes les informations ci-dessous</p>
                </div>
            </div>
            <a href="{{ route('comptable.eleves.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('comptable.eleves.store') }}" class="form-container" id="eleveForm">
            @csrf

            <div class="form-grid">
                <!-- Colonne gauche - Informations élève -->
                <div class="form-column">
                    <div class="section-title">
                        <i class="fas fa-child"></i> Informations de l'élève
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-user"></i> Nom
                            </label>
                            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" 
                                   value="{{ old('nom') }}" placeholder="Nom de l'élève" required>
                            @error('nom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-user"></i> Prénom
                            </label>
                            <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" 
                                   value="{{ old('prenom') }}" placeholder="Prénom de l'élève" required>
                            @error('prenom') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-envelope"></i> Email (connexion élève)
                            </label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" placeholder="eleve@college-ndg.cd" required>
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-lock"></i> Mot de passe
                            </label>
                            <div class="password-input">
                                <input type="password" name="mot_de_passe" id="password" class="form-control @error('mot_de_passe') is-invalid @enderror" 
                                       value="password" placeholder="Mot de passe par défaut: password">
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="form-hint">
                                <i class="fas fa-info-circle"></i> Mot de passe par défaut: <strong>password</strong> (l'élève pourra le modifier après connexion)
                            </small>
                            @error('mot_de_passe') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-calendar"></i> Date de naissance
                            </label>
                            <input type="date" name="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror" 
                                   value="{{ old('date_naissance') }}" required>
                            @error('date_naissance') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-venus-mars"></i> Sexe
                            </label>
                            <select name="sexe" class="form-control @error('sexe') is-invalid @enderror" required>
                                <option value="">Sélectionner</option>
                                <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                                <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                            </select>
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
                                <option value="{{ $classe->id_classe }}" {{ old('classe_id') == $classe->id_classe ? 'selected' : '' }}>
                                    {{ $classe->nom_classe }} - {{ $classe->niveau }} ({{ $classe->effectif }}/{{ $classe->capacite }})
                                </option>
                            @endforeach
                        </select>
                        @error('classe_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Colonne droite - Informations parent -->
                <div class="form-column">
                    <div class="section-title">
                        <i class="fas fa-users"></i> Informations du parent
                    </div>

                    <!-- Sélection du parent existant -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-users"></i> Parent existant
                        </label>
                        <select name="parent_id" id="parentSelect" class="form-control" onchange="fillParentInfo()">
                            <option value="">-- Sélectionner un parent existant --</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}" data-name="{{ $parent->name }}" data-email="{{ $parent->email }}" data-phone="{{ $parent->telephone }}">
                                    {{ $parent->name }} - {{ $parent->email }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-hint">Ou saisissez les informations ci-dessous pour créer un nouveau parent</small>
                    </div>

                    <div class="separator-text">
                        <span>OU</span>
                    </div>

                    <!-- Informations nouveau parent -->
                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-user"></i> Nom du parent
                        </label>
                        <input type="text" name="nom_parent" id="nom_parent" class="form-control @error('nom_parent') is-invalid @enderror" 
                               value="{{ old('nom_parent') }}" placeholder="Nom complet du parent">
                        @error('nom_parent') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-envelope"></i> Email du parent
                        </label>
                        <input type="email" name="email_parent" id="email_parent" class="form-control @error('email_parent') is-invalid @enderror" 
                               value="{{ old('email_parent') }}" placeholder="parent@email.com">
                        <small class="form-hint">Un compte parent sera créé automatiquement si inexistant</small>
                        @error('email_parent') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-phone"></i> Téléphone du parent
                        </label>
                        <div class="phone-input">
                            <span class="phone-prefix">+243</span>
                            <input type="tel" name="telephone_parent" id="telephone_parent" class="form-control @error('telephone_parent') is-invalid @enderror" 
                                   value="{{ old('telephone_parent') }}" placeholder="XXX XXX XXX">
                        </div>
                        @error('telephone_parent') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="info-box">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>À savoir</strong><br>
                            • L'élève pourra se connecter avec l'email renseigné et le mot de passe par défaut: <strong>password</strong><br>
                            • Un compte parent sera automatiquement créé si l'email n'existe pas déjà.<br>
                            • L'élève pourra modifier son mot de passe après sa première connexion.
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Inscrire l'élève
                </button>
                <a href="{{ route('comptable.eleves.index') }}" class="btn-outline">
                    <i class="fas fa-times"></i> Annuler
                </a>
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
        color: #10b981;
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
    .btn-secondary {
        background: #f1f5f9;
        border: none;
        padding: 10px 20px;
        color: #64748b;
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

    .form-container { padding: 25px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
    .form-column { display: flex; flex-direction: column; gap: 5px; }

    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #10b981;
    }
    .section-title i { margin-right: 8px; color: #10b981; }

    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 5px; }
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
        border-color: #10b981;
        box-shadow: 0 0 0 2px rgba(16,185,129,0.1);
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
    .phone-input { display: flex; align-items: center; }
    .phone-prefix {
        background: #f1f5f9;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-right: none;
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
    }
    .phone-input .form-control { border-left: none; }
    .form-hint {
        display: block;
        font-size: 11px;
        color: #64748b;
        margin-top: 5px;
    }
    .form-hint i { margin-right: 4px; }
    .invalid-feedback { display: block; color: #ef4444; font-size: 11px; margin-top: 5px; }

    .separator-text {
        text-align: center;
        margin: 15px 0;
        position: relative;
    }
    .separator-text::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 1px;
        background: #e2e8f0;
    }
    .separator-text span {
        background: white;
        padding: 0 15px;
        position: relative;
        color: #64748b;
        font-size: 12px;
    }

    .info-box {
        background: #eff6ff;
        padding: 15px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        border-left: 3px solid #3b82f6;
        margin-top: 20px;
    }
    .info-box i { color: #3b82f6; font-size: 18px; }
    .info-box div { font-size: 12px; color: #1e293b; line-height: 1.5; }
    .info-box strong { display: block; margin-bottom: 5px; }

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

    @media (max-width: 992px) {
        .form-grid { grid-template-columns: 1fr; gap: 20px; }
        .form-row { grid-template-columns: 1fr; gap: 0; }
    }
    @media (max-width: 768px) {
        .form-header { flex-direction: column; text-align: center; }
        .header-left { flex-direction: column; text-align: center; }
        .form-actions { flex-direction: column; }
        .btn-primary, .btn-outline { justify-content: center; width: 100%; }
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

    function fillParentInfo() {
        const select = document.getElementById('parentSelect');
        const selectedOption = select.options[select.selectedIndex];
        
        if (selectedOption.value) {
            const name = selectedOption.getAttribute('data-name');
            const email = selectedOption.getAttribute('data-email');
            const phone = selectedOption.getAttribute('data-phone');
            
            document.getElementById('nom_parent').value = name;
            document.getElementById('email_parent').value = email;
            document.getElementById('telephone_parent').value = phone;
            
            // Rendre les champs non requis si un parent est sélectionné
            document.getElementById('nom_parent').removeAttribute('required');
            document.getElementById('email_parent').removeAttribute('required');
            document.getElementById('telephone_parent').removeAttribute('required');
        } else {
            // Vider les champs et les rendre requis
            document.getElementById('nom_parent').value = '';
            document.getElementById('email_parent').value = '';
            document.getElementById('telephone_parent').value = '';
            
            document.getElementById('nom_parent').setAttribute('required', 'required');
            document.getElementById('email_parent').setAttribute('required', 'required');
            document.getElementById('telephone_parent').setAttribute('required', 'required');
        }
    }
</script>
@endpush
@endsection