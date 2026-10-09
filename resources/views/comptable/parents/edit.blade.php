{{-- resources/views/comptable/parents/edit.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Modifier un parent')
@section('page-title', 'Modifier le parent')
@section('page-subtitle', 'Modifier les informations du parent')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="form-card">
        <div class="form-header">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div>
                    <h3>Modifier le parent</h3>
                    <p>ID: {{ $parent->identifiant_unique ?? $parent->id }} - {{ $parent->name }}</p>
                </div>
            </div>
            <a href="{{ route('comptable.parents.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('comptable.parents.update', $parent->id) }}" class="form-container">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <!-- Colonne gauche -->
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
                               value="{{ old('name', $parent->name) }}" placeholder="Jean Dupont" required>
                        @error('name') 
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-phone"></i> Téléphone
                        </label>
                        <div class="phone-input">
                            <span class="phone-prefix">+243</span>
                            <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror" 
                                   value="{{ old('telephone', $parent->telephone) }}" placeholder="XXX XXX XXX" required>
                        </div>
                        @error('telephone') 
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-map-marker-alt"></i> Adresse
                        </label>
                        <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror" 
                               value="{{ old('adresse', $parent->adresse) }}" placeholder="Lubumbashi, RDC">
                        @error('adresse') 
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-briefcase"></i> Profession
                        </label>
                        <input type="text" name="profession" class="form-control @error('profession') is-invalid @enderror" 
                               value="{{ old('profession', $parent->profession) }}" placeholder="Profession">
                        @error('profession') 
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Colonne droite -->
                <div class="form-column">
                    <div class="section-title">
                        <div class="title-icon"><i class="fas fa-shield-alt"></i></div>
                        <div>
                            <h4>Sécurité et statut</h4>
                            <p>Configuration du compte</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-circle"></i> Statut du compte
                        </label>
                        <div class="status-selector">
                            <label class="status-option">
                                <input type="radio" name="statut" value="actif" {{ old('statut', $parent->statut) == 'actif' ? 'checked' : '' }}>
                                <div class="status-card status-active">
                                    <i class="fas fa-check-circle"></i>
                                    <div>
                                        <span class="status-name">Actif</span>
                                        <small>Compte actif</small>
                                    </div>
                                </div>
                            </label>
                            <label class="status-option">
                                <input type="radio" name="statut" value="inactif" {{ old('statut', $parent->statut) == 'inactif' ? 'checked' : '' }}>
                                <div class="status-card status-inactive">
                                    <i class="fas fa-ban"></i>
                                    <div>
                                        <span class="status-name">Inactif</span>
                                        <small>Compte désactivé</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('statut') 
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock"></i> Nouveau mot de passe
                        </label>
                        <div class="password-input">
                            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-hint">
                            <i class="fas fa-info-circle"></i> Laisser vide pour conserver l'ancien mot de passe
                        </div>
                        @error('password') 
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-check-circle"></i> Confirmer le mot de passe
                        </label>
                        <div class="password-input">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••">
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistiques du parent -->
            <div class="stats-section">
                <div class="stats-header">
                    <i class="fas fa-chart-line"></i>
                    <span>Statistiques du parent</span>
                </div>
                <div class="stats-grid-mini">
                    <div class="stat-mini">
                        <div class="stat-mini-icon"><i class="fas fa-child"></i></div>
                        <div class="stat-mini-info">
                            <span class="stat-mini-label">Enfants liés</span>
                            <span class="stat-mini-value">{{ $parent->eleves->count() }} élève(s)</span>
                        </div>
                    </div>
                    <div class="stat-mini">
                        <div class="stat-mini-icon"><i class="fas fa-calendar-alt"></i></div>
                        <div class="stat-mini-info">
                            <span class="stat-mini-label">Date d'inscription</span>
                            <span class="stat-mini-value">{{ $parent->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    <div class="stat-mini">
                        <div class="stat-mini-icon"><i class="fas fa-money-bill-wave"></i></div>
                        <div class="stat-mini-info">
                            <span class="stat-mini-label">Total payé</span>
                            <span class="stat-mini-value">{{ number_format($parent->paiements->where('statut', 'valide')->sum('montant'), 0, ',', ' ') }} FC</span>
                        </div>
                    </div>
                    <div class="stat-mini">
                        <div class="stat-mini-icon"><i class="fas fa-clock"></i></div>
                        <div class="stat-mini-info">
                            <span class="stat-mini-label">Dernière connexion</span>
                            <span class="stat-mini-value">{{ $parent->last_login_at ? $parent->last_login_at->format('d/m/Y') : 'Jamais' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
                <a href="{{ route('comptable.parents.show', $parent->id) }}" class="btn-outline">
                    <i class="fas fa-eye"></i> Voir les détails
                </a>
                <a href="{{ route('comptable.parents.index') }}" class="btn-outline">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>

</div>

@push('styles')
<style>
    /* ========================================== */
    /* FORM CARD PRINCIPAL */
    /* ========================================== */
    .form-card {
        background: white;
        border-radius: 0px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    /* Header */
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
        text-decoration: none;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }
    .btn-secondary:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    /* Formulaire */
    .form-container {
        padding: 25px;
    }
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 25px;
    }
    .form-group {
        margin-bottom: 20px;
    }

    /* Section Title */
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

    /* Labels & Inputs */
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
    .form-hint {
        display: block;
        font-size: 11px;
        color: #64748b;
        margin-top: 5px;
    }
    .form-hint i {
        margin-right: 4px;
    }

    /* Phone Input */
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

    /* Password Input */
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

    /* Status Selector */
    .status-selector {
        display: flex;
        gap: 15px;
        margin-top: 5px;
    }
    .status-option {
        flex: 1;
        cursor: pointer;
    }
    .status-option input {
        display: none;
    }
    .status-option input:checked + .status-card {
        border-color: #10b981;
        background: #ecfdf5;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(16,185,129,0.15);
    }
    .status-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s;
        cursor: pointer;
    }
    .status-card i {
        font-size: 24px;
    }
    .status-name {
        display: block;
        font-weight: 600;
        font-size: 14px;
    }
    .status-card small {
        display: block;
        font-size: 10px;
        color: #64748b;
    }
    .status-active i { color: #10b981; }
    .status-inactive i { color: #ef4444; }

    /* Stats Section */
    .stats-section {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 20px;
        margin: 20px 0;
        border: 1px solid #e2e8f0;
    }
    .stats-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e2e8f0;
        font-weight: 600;
        font-size: 14px;
        color: #1e293b;
    }
    .stats-header i {
        color: #10b981;
        font-size: 18px;
    }
    .stats-grid-mini {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 15px;
    }
    .stat-mini {
        display: flex;
        align-items: center;
        gap: 12px;
        background: white;
        padding: 12px;
        border: 1px solid #e2e8f0;
    }
    .stat-mini-icon {
        width: 40px;
        height: 40px;
        background: #ecfdf5;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
        font-size: 18px;
    }
    .stat-mini-info {
        flex: 1;
    }
    .stat-mini-label {
        display: block;
        font-size: 10px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-mini-value {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
    }

    /* Form Actions */
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

    /* Responsive */
    @media (max-width: 992px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .stats-grid-mini {
            grid-template-columns: repeat(2, 1fr);
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
        .status-selector {
            flex-direction: column;
        }
        .stats-grid-mini {
            grid-template-columns: 1fr;
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
</script>
@endpush
@endsection