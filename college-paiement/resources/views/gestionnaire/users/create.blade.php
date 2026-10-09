{{-- resources/views/gestionnaire/users/create.blade.php --}}
@extends('layouts.gestionnaire')

@section('title', 'Ajouter un utilisateur')
@section('page-title', 'Nouvel utilisateur')
@section('page-subtitle', 'Créer un compte utilisateur')

@section('content')
<div class="create-user-container">

    <!-- En-tête -->
    <div class="form-header">
        <div class="header-left">
            <div class="header-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <div>
                <h3>Nouvel utilisateur</h3>
                <p>Remplissez les informations ci-dessous pour créer un compte</p>
            </div>
        </div>
        <a href="{{ route('gestionnaire.users.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <!-- Formulaire -->
    <div class="form-card">
        <form method="POST" action="{{ route('gestionnaire.users.store') }}" class="form-container">
            @csrf

            <div class="form-grid">
                <!-- Colonne gauche -->
                <div class="form-column">
                    <div class="section-title">
                        <div class="title-icon"><i class="fas fa-user-circle"></i></div>
                        <div>
                            <h4>Informations personnelles</h4>
                            <p>Données de l'utilisateur</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-user"></i> Nom complet
                        </label>
                        <div class="input-group">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" placeholder="Jean Dupont" required>
                        </div>
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" placeholder="jean.dupont@email.com" required>
                        </div>
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-phone"></i> Téléphone
                        </label>
                        <div class="input-group">
                            <i class="fas fa-phone input-icon"></i>
                            <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror" 
                                   value="{{ old('telephone') }}" placeholder="+243 XXX XXX XXX" required>
                        </div>
                        @error('telephone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt"></i> Adresse
                        </label>
                        <div class="input-group">
                            <i class="fas fa-map-marker-alt input-icon"></i>
                            <input type="text" name="adresse" class="form-control" value="{{ old('adresse') }}" placeholder="Lubumbashi, RDC">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-briefcase"></i> Profession
                        </label>
                        <div class="input-group">
                            <i class="fas fa-briefcase input-icon"></i>
                            <input type="text" name="profession" class="form-control" value="{{ old('profession') }}" placeholder="Profession">
                        </div>
                    </div>
                </div>

                <!-- Colonne droite -->
                <div class="form-column">
                    <div class="section-title">
                        <div class="title-icon"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <h4>Sécurité et accès</h4>
                            <p>Configuration du compte</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-tag"></i> Rôle
                        </label>
                        <div class="role-selector">
                            <label class="role-option">
                                <input type="radio" name="role" value="gestionnaire" {{ old('role') == 'gestionnaire' ? 'checked' : '' }} required>
                                <div class="role-card role-gestionnaire-card">
                                    <i class="fas fa-user-shield"></i>
                                    <span>Gestionnaire</span>
                                    <small>Accès total au système</small>
                                </div>
                            </label>
                            <label class="role-option">
                                <input type="radio" name="role" value="comptable" {{ old('role') == 'comptable' ? 'checked' : '' }}>
                                <div class="role-card role-comptable-card">
                                    <i class="fas fa-calculator"></i>
                                    <span>Comptable</span>
                                    <small>Gestion financière</small>
                                </div>
                            </label>
                            <label class="role-option">
                                <input type="radio" name="role" value="parent" {{ old('role') == 'parent' ? 'checked' : '' }}>
                                <div class="role-card role-parent-card">
                                    <i class="fas fa-users"></i>
                                    <span>Parent</span>
                                    <small>Accès parent d'élève</small>
                                </div>
                            </label>
                        </div>
                        @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-lock"></i> Mot de passe
                        </label>
                        <div class="password-input">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="••••••••" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small class="form-hint">
                            <i class="fas fa-info-circle"></i> Minimum 8 caractères
                        </small>
                        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-check-circle"></i> Confirmer le mot de passe
                        </label>
                        <div class="password-input">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                                   placeholder="••••••••" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="info-box">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>Informations importantes</strong><br>
                            L'utilisateur recevra un email de confirmation après la création de son compte.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Créer l'utilisateur
                </button>
                <a href="{{ route('gestionnaire.users.index') }}" class="btn-outline">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>

</div>

@push('styles')
<style>
/* ============================================
   AJOUTER UTILISATEUR - DESIGN MODERNE
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
    --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
    --transition: all 0.3s ease;
}

.create-user-container {
    max-width: 1200px;
    margin: 0 auto;
}

/* Coins carrés */
.form-header, .header-icon, .btn-secondary, .form-card, .role-card,
.password-input, .password-toggle, .info-box, .btn-primary, .btn-outline {
    border-radius: 0px !important;
}

/* ==========================================
   EN-TÊTE
   ========================================== */
.form-header {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    padding: 1.25rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--border);
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    width: 50px;
    height: 50px;
    background: var(--gradient-primary);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--white);
}

.header-icon i {
    font-size: 1.375rem;
}

.header-left h3 {
    font-size: 1.125rem;
    font-weight: 700;
    margin: 0;
    color: var(--dark);
}

.header-left p {
    font-size: 0.75rem;
    margin: 0.25rem 0 0 0;
    color: var(--gray);
}

.btn-secondary {
    background: #f1f5f9;
    border: none;
    padding: 0.5rem 1.25rem;
    color: var(--gray);
    text-decoration: none;
    font-size: 0.813rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
}

.btn-secondary:hover {
    background: #e2e8f0;
    color: var(--dark);
}

/* ==========================================
   FORMULAIRE
   ========================================== */
.form-card {
    background: var(--white);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    overflow: hidden;
}

.form-container {
    padding: 1.5rem;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
}

.form-group {
    margin-bottom: 1.25rem;
}

/* Section Title */
.section-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid var(--border);
}

.title-icon {
    width: 40px;
    height: 40px;
    background: rgba(79, 70, 229, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
}

.title-icon i {
    font-size: 1.125rem;
}

.section-title h4 {
    font-size: 1rem;
    font-weight: 700;
    margin: 0;
    color: var(--dark);
}

.section-title p {
    font-size: 0.688rem;
    margin: 0.125rem 0 0 0;
    color: var(--gray);
}

/* Labels */
.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    font-size: 0.813rem;
    color: var(--dark);
}

.form-label.required::after {
    content: '*';
    color: var(--danger);
    margin-left: 0.25rem;
}

.form-label i {
    margin-right: 0.5rem;
    color: var(--primary);
    width: 1.125rem;
}

/* Input group */
.input-group {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 0.875rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray);
    font-size: 0.875rem;
    transition: var(--transition);
    pointer-events: none;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.25rem;
    border: 1px solid var(--border);
    font-size: 0.875rem;
    transition: var(--transition);
    background: var(--white);
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
}

.invalid-feedback {
    display: block;
    color: var(--danger);
    font-size: 0.688rem;
    margin-top: 0.25rem;
}

.form-hint {
    display: block;
    font-size: 0.688rem;
    color: var(--gray);
    margin-top: 0.25rem;
}

.form-hint i {
    margin-right: 0.25rem;
    color: var(--primary);
}

/* Role Selector */
.role-selector {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.75rem;
}

.role-option {
    cursor: pointer;
}

.role-option input {
    display: none;
}

.role-option input:checked + .role-card {
    border-color: var(--primary);
    background: rgba(79, 70, 229, 0.05);
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.role-card {
    padding: 0.75rem 0.5rem;
    text-align: center;
    border: 2px solid var(--border);
    transition: var(--transition);
    cursor: pointer;
}

.role-card i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    display: block;
}

.role-card span {
    display: block;
    font-weight: 600;
    font-size: 0.813rem;
    color: var(--dark);
}

.role-card small {
    display: block;
    font-size: 0.625rem;
    color: var(--gray);
    margin-top: 0.25rem;
}

.role-gestionnaire-card i { color: var(--primary); }
.role-comptable-card i { color: var(--success); }
.role-parent-card i { color: var(--warning); }

/* Password Input */
.password-input {
    position: relative;
    display: flex;
    align-items: center;
}

.password-input input {
    flex: 1;
    padding-right: 2.5rem;
}

.password-toggle {
    position: absolute;
    right: 0.75rem;
    background: none;
    border: none;
    color: var(--gray);
    cursor: pointer;
    transition: var(--transition);
}

.password-toggle:hover {
    color: var(--primary);
}

/* Info Box */
.info-box {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.05) 0%, rgba(99, 102, 241, 0.05) 100%);
    padding: 1rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    border-left: 3px solid var(--primary);
    margin-top: 1rem;
}

.info-box i {
    color: var(--primary);
    font-size: 1.125rem;
}

.info-box div {
    font-size: 0.813rem;
    color: var(--dark);
    line-height: 1.5;
}

.info-box strong {
    display: block;
    margin-bottom: 0.25rem;
}

/* Actions */
.form-actions {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border);
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn-primary {
    background: var(--gradient-primary);
    border: none;
    padding: 0.75rem 1.75rem;
    color: var(--white);
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    transition: var(--transition);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3);
}

.btn-outline {
    background: transparent;
    border: 1px solid var(--border);
    padding: 0.688rem 1.688rem;
    color: var(--gray);
    font-size: 0.875rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: var(--transition);
}

.btn-outline:hover {
    border-color: var(--danger);
    color: var(--danger);
}

/* ==========================================
   RESPONSIVE
   ========================================== */
@media (max-width: 992px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
    
    .role-selector {
        grid-template-columns: repeat(3, 1fr);
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
    
    .role-selector {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-primary, .btn-outline {
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .form-container {
        padding: 1rem;
    }
    
    .form-card {
        margin: 0;
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
</script>
@endpush
@endsection