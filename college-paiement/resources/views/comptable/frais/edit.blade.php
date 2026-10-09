{{-- resources/views/comptable/frais/edit.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Modifier un frais')
@section('page-title', 'Modifier le frais scolaire')
@section('page-subtitle', 'Modifier les informations du frais')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="form-card">
        <div class="form-header">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h3>Modifier le frais</h3>
                    <p>ID: {{ $frais->id_frais }} - {{ $frais->libelle }}</p>
                </div>
            </div>
            <a href="{{ route('comptable.frais.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('comptable.frais.update', $frais->id_frais) }}" class="form-container">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <!-- Colonne gauche -->
                <div class="form-column">
                    <div class="section-title">
                        <div class="title-icon"><i class="fas fa-info-circle"></i></div>
                        <div>
                            <h4>Informations générales</h4>
                            <p>Détails du frais scolaire</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-tag"></i> Libellé du frais
                        </label>
                        <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror" 
                               value="{{ old('libelle', $frais->libelle) }}" placeholder="Ex: Minerval, Scolarité, Transport" required>
                        @error('libelle') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-align-left"></i> Description
                        </label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3" placeholder="Description détaillée du frais (optionnel)">{{ old('description', $frais->description) }}</textarea>
                        @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-building"></i> Classe concernée
                        </label>
                        <select name="classe_id" class="form-control @error('classe_id') is-invalid @enderror" required>
                            <option value="">Sélectionner une classe</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id_classe }}" {{ old('classe_id', $frais->classe_id) == $classe->id_classe ? 'selected' : '' }}>
                                    {{ $classe->nom_classe }} - {{ $classe->niveau }} ({{ $classe->effectif }} élèves)
                                </option>
                            @endforeach
                        </select>
                        @error('classe_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Colonne droite -->
                <div class="form-column">
                    <div class="section-title">
                        <div class="title-icon"><i class="fas fa-money-bill-wave"></i></div>
                        <div>
                            <h4>Montant et devise</h4>
                            <p>Configuration financière</p>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-money-bill"></i> Montant
                            </label>
                            <div class="amount-input">
                                <input type="number" name="montant" class="form-control @error('montant') is-invalid @enderror" 
                                       value="{{ old('montant', $frais->montant) }}" step="100" required>
                                <span class="amount-suffix">FC</span>
                            </div>
                            @error('montant') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-dollar-sign"></i> Devise
                            </label>
                            <div class="devise-selector">
                                <label class="devise-option">
                                    <input type="radio" name="devise" value="FC" {{ old('devise', $frais->devise) == 'FC' ? 'checked' : '' }} required>
                                    <div class="devise-card devise-fc">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <strong>FC</strong>
                                        <small>Franc Congolais</small>
                                    </div>
                                </label>
                                <label class="devise-option">
                                    <input type="radio" name="devise" value="USD" {{ old('devise', $frais->devise) == 'USD' ? 'checked' : '' }}>
                                    <div class="devise-card devise-usd">
                                        <i class="fas fa-dollar-sign"></i>
                                        <strong>USD</strong>
                                        <small>Dollar US</small>
                                    </div>
                                </label>
                            </div>
                            @error('devise') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-exclamation-triangle"></i> Pénalité de retard
                            </label>
                            <div class="penalty-input">
                                <input type="number" name="penalite" class="form-control @error('penalite') is-invalid @enderror" 
                                       value="{{ old('penalite', $frais->penalite) }}" step="100">
                                <span class="penalty-suffix">{{ $frais->devise ?? 'FC' }}</span>
                            </div>
                            <small class="form-hint">
                                <i class="fas fa-info-circle"></i> Montant ajouté en cas de paiement après la date d'échéance
                            </small>
                            @error('penalite') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-calendar-alt"></i> Date d'échéance
                            </label>
                            <input type="date" name="date_echeance" class="form-control @error('date_echeance') is-invalid @enderror" 
                                   value="{{ old('date_echeance', $frais->date_echeance->format('Y-m-d')) }}" required>
                            @error('date_echeance') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-calendar-week"></i> Périodicité
                        </label>
                        <div class="periodicite-selector">
                            <label class="periodicite-option">
                                <input type="radio" name="periodicite" value="mensuel" {{ old('periodicite', $frais->periodicite) == 'mensuel' ? 'checked' : '' }}>
                                <div class="periodicite-card">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Mensuel</span>
                                </div>
                            </label>
                            <label class="periodicite-option">
                                <input type="radio" name="periodicite" value="trimestriel" {{ old('periodicite', $frais->periodicite) == 'trimestriel' ? 'checked' : '' }}>
                                <div class="periodicite-card">
                                    <i class="fas fa-calendar-week"></i>
                                    <span>Trimestriel</span>
                                </div>
                            </label>
                            <label class="periodicite-option">
                                <input type="radio" name="periodicite" value="semestriel" {{ old('periodicite', $frais->periodicite) == 'semestriel' ? 'checked' : '' }}>
                                <div class="periodicite-card">
                                    <i class="fas fa-calendar-half"></i>
                                    <span>Semestriel</span>
                                </div>
                            </label>
                            <label class="periodicite-option">
                                <input type="radio" name="periodicite" value="annuel" {{ old('periodicite', $frais->periodicite) == 'annuel' ? 'checked' : '' }}>
                                <div class="periodicite-card">
                                    <i class="fas fa-calendar-year"></i>
                                    <span>Annuel</span>
                                </div>
                            </label>
                        </div>
                        @error('periodicite') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-circle"></i> Statut
                        </label>
                        <div class="status-selector">
                            <label class="status-option">
                                <input type="radio" name="statut" value="actif" {{ old('statut', $frais->statut) == 'actif' ? 'checked' : '' }}>
                                <span class="status-badge status-active">
                                    <i class="fas fa-check-circle"></i> Actif
                                </span>
                            </label>
                            <label class="status-option">
                                <input type="radio" name="statut" value="inactif" {{ old('statut', $frais->statut) == 'inactif' ? 'checked' : '' }}>
                                <span class="status-badge status-inactive">
                                    <i class="fas fa-ban"></i> Inactif
                                </span>
                            </label>
                        </div>
                        @error('statut') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="info-stats">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-calendar-plus"></i></div>
                    <div class="stat-content">
                        <span class="stat-label">Date de création</span>
                        <span class="stat-value">{{ $frais->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-edit"></i></div>
                    <div class="stat-content">
                        <span class="stat-label">Dernière modification</span>
                        <span class="stat-value">{{ $frais->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                    <div class="stat-content">
                        <span class="stat-label">Taux de recouvrement</span>
                        <span class="stat-value">{{ $tauxRecouvrement ?? 0 }}%</span>
                        <div class="progress-bar-mini">
                            <div class="progress-fill" style="width: {{ $tauxRecouvrement ?? 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>À savoir</strong><br>
                    Les frais marqués comme "Inactifs" ne seront pas visibles pour les paiements.<br>
                    La pénalité est automatiquement appliquée après la date d'échéance.
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Mettre à jour
                </button>
                <a href="{{ route('comptable.frais.show', $frais->id_frais) }}" class="btn-outline">
                    <i class="fas fa-eye"></i> Voir les détails
                </a>
                <a href="{{ route('comptable.frais.index') }}" class="btn-outline">
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
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
        color: #f59e0b;
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
        border-color: #f59e0b;
        box-shadow: 0 0 0 2px rgba(245,158,11,0.1);
    }
    textarea.form-control {
        resize: vertical;
    }
    select.form-control {
        cursor: pointer;
        appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="%2364748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>');
        background-repeat: no-repeat;
        background-position: right 12px center;
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
        background: #fffbeb;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #f59e0b;
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
    /* AMOUNT INPUT */
    /* ========================================== */
    .amount-input {
        display: flex;
        align-items: center;
    }
    .amount-input .form-control {
        flex: 1;
        border-right: none;
    }
    .amount-suffix {
        background: #f1f5f9;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-left: none;
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
    }

    /* ========================================== */
    /* PENALTY INPUT */
    /* ========================================== */
    .penalty-input {
        display: flex;
        align-items: center;
    }
    .penalty-input .form-control {
        flex: 1;
        border-right: none;
    }
    .penalty-suffix {
        background: #f1f5f9;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-left: none;
        font-size: 14px;
        font-weight: 500;
        color: #64748b;
    }

    /* ========================================== */
    /* DEVISE SELECTOR */
    /* ========================================== */
    .devise-selector {
        display: flex;
        gap: 15px;
    }
    .devise-option {
        flex: 1;
        cursor: pointer;
    }
    .devise-option input {
        display: none;
    }
    .devise-option input:checked + .devise-card {
        border-color: #f59e0b;
        background: #fffbeb;
        transform: translateY(-2px);
    }
    .devise-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 15px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s;
        cursor: pointer;
    }
    .devise-card i {
        font-size: 28px;
    }
    .devise-card strong {
        font-size: 18px;
    }
    .devise-card small {
        font-size: 10px;
        color: #64748b;
    }
    .devise-fc i { color: #10b981; }
    .devise-usd i { color: #f59e0b; }

    /* ========================================== */
    /* PERIODICITE SELECTOR */
    /* ========================================== */
    .periodicite-selector {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .periodicite-option {
        cursor: pointer;
    }
    .periodicite-option input {
        display: none;
    }
    .periodicite-option input:checked + .periodicite-card {
        background: #f59e0b;
        color: white;
        border-color: #f59e0b;
    }
    .periodicite-card {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
    }
    .periodicite-card:hover {
        border-color: #f59e0b;
    }

    /* ========================================== */
    /* STATUS SELECTOR */
    /* ========================================== */
    .status-selector {
        display: flex;
        gap: 15px;
    }
    .status-option {
        cursor: pointer;
    }
    .status-option input {
        display: none;
    }
    .status-option input:checked + .status-badge {
        opacity: 1;
        transform: scale(1.02);
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 20px;
        font-size: 13px;
        font-weight: 500;
        opacity: 0.6;
        transition: all 0.3s;
    }
    .status-active {
        background: #d1fae5;
        color: #059669;
    }
    .status-inactive {
        background: #fee2e2;
        color: #dc2626;
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
        color: #f59e0b;
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
    .progress-bar-mini {
        margin-top: 6px;
        background: #e2e8f0;
        height: 4px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #f59e0b, #d97706);
        transition: width 0.3s;
    }

    /* ========================================== */
    /* INFO BOX */
    /* ========================================== */
    .info-box {
        background: #fffbeb;
        padding: 15px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        border-left: 3px solid #f59e0b;
        margin: 20px 0;
    }
    .info-box i {
        color: #f59e0b;
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
        background: #f59e0b;
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
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(245,158,11,0.3);
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
        .devise-selector, .periodicite-selector, .status-selector {
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
@endsection