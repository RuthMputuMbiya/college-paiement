{{-- resources/views/eleve/profile/password.blade.php --}}
@extends('layouts.eleve')

@section('title', 'Changer mon mot de passe')
@section('page-title', 'Sécurité du compte')
@section('page-subtitle', 'Modifiez votre mot de passe de connexion')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="row g-4">
        <!-- Colonne gauche - Informations de sécurité -->
        <div class="col-lg-4">
            <div class="security-card">
                <div class="security-header">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Sécurité du compte</h3>
                    <p>Protégez votre compte avec un mot de passe fort</p>
                </div>
                <div class="security-tips">
                    <h4><i class="fas fa-lightbulb"></i> Conseils de sécurité</h4>
                    <ul>
                        <li><i class="fas fa-check-circle"></i> Utilisez au moins 8 caractères</li>
                        <li><i class="fas fa-check-circle"></i> Mélangez lettres majuscules et minuscules</li>
                        <li><i class="fas fa-check-circle"></i> Ajoutez des chiffres</li>
                        <li><i class="fas fa-check-circle"></i> Utilisez des caractères spéciaux (!@#$%^&*)</li>
                        <li><i class="fas fa-check-circle"></i> N'utilisez pas le même mot de passe que vos autres comptes</li>
                    </ul>
                </div>
                <div class="security-note">
                    <i class="fas fa-info-circle"></i>
                    <span>Changez régulièrement votre mot de passe pour plus de sécurité</span>
                </div>
            </div>
        </div>

        <!-- Colonne droite - Formulaire changement mot de passe -->
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-header">
                    <div class="header-left">
                        <i class="fas fa-key"></i>
                        <div>
                            <h3>Changer le mot de passe</h3>
                            <p>Créez un nouveau mot de passe sécurisé</p>
                        </div>
                    </div>
                </div>

                <div class="form-body">
                    @if(session('success'))
                    <div class="alert-custom alert-success mb-4">
                        <i class="fas fa-check-circle"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert-custom alert-error mb-4">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('eleve.profile.update-password') }}" id="passwordForm">
                        @csrf
                        @method('PUT')

                        <!-- Nouveau mot de passe -->
                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-lock"></i> Nouveau mot de passe
                            </label>
                            <div class="password-input">
                                <input type="password" name="password" id="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="••••••••" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            
                            <!-- Indicateur de force du mot de passe -->
                            <div class="password-strength mt-3">
                                <div class="strength-label">Force du mot de passe</div>
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                                <div class="strength-text" id="strengthText">Entrez un mot de passe</div>
                                <div class="strength-requirements" id="strengthRequirements">
                                    <div class="req-item" id="reqLength">
                                        <i class="fas fa-circle"></i> Au moins 8 caractères
                                    </div>
                                    <div class="req-item" id="reqLower">
                                        <i class="fas fa-circle"></i> Au moins une minuscule
                                    </div>
                                    <div class="req-item" id="reqUpper">
                                        <i class="fas fa-circle"></i> Au moins une majuscule
                                    </div>
                                    <div class="req-item" id="reqNumber">
                                        <i class="fas fa-circle"></i> Au moins un chiffre
                                    </div>
                                    <div class="req-item" id="reqSpecial">
                                        <i class="fas fa-circle"></i> Au moins un caractère spécial
                                    </div>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirmation mot de passe -->
                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-check-circle"></i> Confirmer le mot de passe
                            </label>
                            <div class="password-input">
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="form-control" placeholder="••••••••" required>
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

                        <!-- Boutons d'action -->
                        <div class="form-actions">
                            <a href="{{ route('eleve.profile.index') }}" class="btn-outline">
                                <i class="fas fa-times"></i> Annuler
                            </a>
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

    /* Security Card */
    .security-card {
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 20px;
    }
    .security-header {
        background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
        padding: 25px 20px;
        text-align: center;
        color: white;
    }
    .security-header i {
        font-size: 40px;
        margin-bottom: 15px;
        display: inline-block;
    }
    .security-header h3 {
        font-size: 18px;
        font-weight: 700;
        margin: 0 0 5px 0;
    }
    .security-header p {
        font-size: 12px;
        opacity: 0.8;
        margin: 0;
    }

    .security-tips {
        padding: 20px;
        border-bottom: 1px solid #e2e8f0;
    }
    .security-tips h4 {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 15px;
    }
    .security-tips h4 i {
        margin-right: 8px;
        color: #ea580c;
    }
    .security-tips ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .security-tips li {
        padding: 8px 0;
        font-size: 13px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .security-tips li i {
        color: #10b981;
        font-size: 12px;
    }

    .security-note {
        padding: 15px 20px;
        background: #fef3c7;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        color: #92400e;
    }
    .security-note i {
        font-size: 16px;
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

    /* Alertes */
    .alert-custom {
        padding: 12px 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
    }
    .alert-success {
        background: #ecfdf5;
        border-left: 3px solid #10b981;
        color: #065f46;
    }
    .alert-error {
        background: #fef2f2;
        border-left: 3px solid #ef4444;
        color: #991b1b;
    }

    /* Form Group */
    .form-group {
        margin-bottom: 25px;
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
    .form-control.is-valid {
        border-color: #10b981;
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
    .valid-feedback {
        display: block;
        color: #10b981;
        font-size: 11px;
        margin-top: 5px;
    }

    /* Password Strength */
    .password-strength {
        margin-top: 10px;
    }
    .strength-label {
        font-size: 11px;
        color: #64748b;
        margin-bottom: 5px;
    }
    .strength-bar {
        height: 4px;
        background: #e2e8f0;
        margin-bottom: 8px;
    }
    .strength-fill {
        height: 100%;
        width: 0%;
        transition: all 0.3s;
    }
    .strength-text {
        font-size: 11px;
        margin-bottom: 10px;
    }
    .strength-requirements {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 10px;
    }
    .req-item {
        font-size: 10px;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .req-item i {
        font-size: 6px;
        color: #94a3b8;
    }
    .req-item.valid {
        color: #10b981;
    }
    .req-item.valid i {
        color: #10b981;
    }

    /* Form Actions */
    .form-actions {
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 15px;
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
    .btn-outline {
        background: transparent;
        border: 1px solid #e2e8f0;
        padding: 9px 24px;
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

    /* Responsive */
    @media (max-width: 992px) {
        .col-lg-4, .col-lg-8 {
            width: 100%;
        }
    }
    @media (max-width: 768px) {
        .form-actions {
            flex-direction: column;
        }
        .btn-primary, .btn-outline {
            justify-content: center;
            width: 100%;
        }
        .strength-requirements {
            flex-direction: column;
            gap: 5px;
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
    
    // Requirements elements
    const reqLength = document.getElementById('reqLength');
    const reqLower = document.getElementById('reqLower');
    const reqUpper = document.getElementById('reqUpper');
    const reqNumber = document.getElementById('reqNumber');
    const reqSpecial = document.getElementById('reqSpecial');

    function checkPasswordStrength(password) {
        let strength = 0;
        let validCount = 0;
        
        // Check length
        if (password.length >= 8) {
            reqLength.classList.add('valid');
            reqLength.querySelector('i').className = 'fas fa-check-circle';
            validCount++;
        } else {
            reqLength.classList.remove('valid');
            reqLength.querySelector('i').className = 'fas fa-circle';
        }
        
        // Check lowercase
        if (password.match(/[a-z]/)) {
            reqLower.classList.add('valid');
            reqLower.querySelector('i').className = 'fas fa-check-circle';
            validCount++;
        } else {
            reqLower.classList.remove('valid');
            reqLower.querySelector('i').className = 'fas fa-circle';
        }
        
        // Check uppercase
        if (password.match(/[A-Z]/)) {
            reqUpper.classList.add('valid');
            reqUpper.querySelector('i').className = 'fas fa-check-circle';
            validCount++;
        } else {
            reqUpper.classList.remove('valid');
            reqUpper.querySelector('i').className = 'fas fa-circle';
        }
        
        // Check number
        if (password.match(/[0-9]/)) {
            reqNumber.classList.add('valid');
            reqNumber.querySelector('i').className = 'fas fa-check-circle';
            validCount++;
        } else {
            reqNumber.classList.remove('valid');
            reqNumber.querySelector('i').className = 'fas fa-circle';
        }
        
        // Check special character
        if (password.match(/[^a-zA-Z0-9]/)) {
            reqSpecial.classList.add('valid');
            reqSpecial.querySelector('i').className = 'fas fa-check-circle';
            validCount++;
        } else {
            reqSpecial.classList.remove('valid');
            reqSpecial.querySelector('i').className = 'fas fa-circle';
        }
        
        // Calculate strength
        if (password.length === 0) {
            strengthFill.style.width = '0%';
            strengthText.innerHTML = 'Entrez un mot de passe';
            strengthText.style.color = '#64748b';
            strengthFill.style.backgroundColor = '#e2e8f0';
            return;
        }
        
        if (validCount <= 2) {
            strengthFill.style.backgroundColor = '#ef4444';
            strengthText.style.color = '#ef4444';
            strengthText.innerHTML = 'Mot de passe : Faible';
        } else if (validCount <= 4) {
            strengthFill.style.backgroundColor = '#f59e0b';
            strengthText.style.color = '#f59e0b';
            strengthText.innerHTML = 'Mot de passe : Moyen';
        } else {
            strengthFill.style.backgroundColor = '#10b981';
            strengthText.style.color = '#10b981';
            strengthText.innerHTML = 'Mot de passe : Fort';
        }
        
        strengthFill.style.width = (validCount / 5 * 100) + '%';
    }

    passwordInput.addEventListener('input', function() {
        checkPasswordStrength(this.value);
        validatePasswordMatch();
    });

    // Password confirmation validation
    const passwordConfirm = document.getElementById('password_confirmation');
    const passwordMatchError = document.getElementById('passwordMatchError');
    const passwordMatchSuccess = document.getElementById('passwordMatchSuccess');
    const submitBtn = document.getElementById('submitBtn');

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

    // Form validation before submit
    const passwordForm = document.getElementById('passwordForm');
    passwordForm.addEventListener('submit', function(e) {
        if (!validatePasswordMatch()) {
            e.preventDefault();
            passwordMatchError.style.display = 'block';
            passwordMatchSuccess.style.display = 'none';
        }
        
        // Check if password is strong enough
        const validCount = document.querySelectorAll('.req-item.valid').length;
        if (validCount < 3 && passwordInput.value !== '') {
            e.preventDefault();
            alert('Veuillez choisir un mot de passe plus sécurisé (au moins 3 critères)');
        }
    });
</script>
@endpush
@endsection