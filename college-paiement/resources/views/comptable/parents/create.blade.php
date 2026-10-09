{{-- resources/views/comptable/parents/create.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Ajouter un parent')
@section('page-title', 'Nouveau parent')
@section('page-subtitle', 'Créer un compte parent')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="form-card">
        <div class="form-header">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div>
                    <h3>Nouveau parent</h3>
                    <p>Remplissez les informations ci-dessous</p>
                </div>
            </div>
            <a href="{{ route('comptable.parents.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('comptable.parents.store') }}" class="form-container">
            @csrf

            <div class="form-grid">
                <div class="form-column">
                    <div class="section-title">
                        <div class="title-icon"><i class="fas fa-user-circle"></i></div>
                        <div>
                            <h4>Informations personnelles</h4>
                            <p>Données du parent</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-user"></i> Nom complet
                        </label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="Jean Dupont" required>
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" placeholder="parent@email.com" required>
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-phone"></i> Téléphone
                        </label>
                        <div class="phone-input">
                            <span class="phone-prefix">+243</span>
                            <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror" 
                                   value="{{ old('telephone') }}" placeholder="XXX XXX XXX" required>
                        </div>
                        @error('telephone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-column">
                    <div class="section-title">
                        <div class="title-icon"><i class="fas fa-info-circle"></i></div>
                        <div>
                            <h4>Informations complémentaires</h4>
                            <p>Adresse et profession</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt"></i> Adresse
                        </label>
                        <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror" 
                               value="{{ old('adresse') }}" placeholder="Lubumbashi, RDC">
                        @error('adresse') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-briefcase"></i> Profession
                        </label>
                        <input type="text" name="profession" class="form-control @error('profession') is-invalid @enderror" 
                               value="{{ old('profession') }}" placeholder="Profession">
                        @error('profession') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-lock"></i> Mot de passe
                        </label>
                        <div class="password-input">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
            </div>

            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>À savoir</strong><br>
                    Le parent pourra se connecter avec son email et son mot de passe.<br>
                    Il pourra ensuite lier ses enfants à son compte.
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Créer le parent
                </button>
                <a href="{{ route('comptable.parents.index') }}" class="btn-outline">
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
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
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
        padding: 10px 20px;
        color: #64748b;
        text-decoration: none;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .btn-secondary:hover { background: #e2e8f0; color: #1e293b; }

    .form-container { padding: 25px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
    .form-column { display: flex; flex-direction: column; gap: 5px; }

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

    .form-group { margin-bottom: 20px; }
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 13px;
        color: #1e293b;
    }
    .form-label.required::after { content: '*'; color: #ef4444; margin-left: 4px; }
    .form-label i { margin-right: 8px; color: #10b981; }
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
    .invalid-feedback { display: block; color: #ef4444; font-size: 11px; margin-top: 5px; }

    .phone-input { display: flex; align-items: center; }
    .phone-prefix {
        background: #f1f5f9;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-right: none;
        font-size: 14px;
        font-weight: 500;
    }
    .phone-input .form-control { border-left: none; }

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

    .info-box {
        background: #eff6ff;
        padding: 15px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        border-left: 3px solid #3b82f6;
        margin: 20px 0;
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

    @media (max-width: 992px) { .form-grid { grid-template-columns: 1fr; gap: 20px; } }
    @media (max-width: 768px) {
        .form-header { flex-direction: column; text-align: center; }
        .header-left { flex-direction: column; text-align: center; }
        .form-actions { flex-direction: column; }
        .btn-primary, .btn-outline { justify-content: center; }
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