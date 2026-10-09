{{-- resources/views/comptable/frais/create.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Ajouter un frais')
@section('page-title', 'Ajouter un frais scolaire')
@section('page-subtitle', 'Définir les frais par classe (FC ou USD)')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="form-card">
        <div class="form-header">
            <div class="header-left">
                <i class="fas fa-plus-circle"></i>
                <div>
                    <h3>Nouveau frais scolaire</h3>
                    <p>Remplissez toutes les informations ci-dessous</p>
                </div>
            </div>
            <a href="{{ route('comptable.frais.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('comptable.frais.store') }}" class="form-container">
            @csrf

            <div class="form-grid">
                <!-- Colonne gauche -->
                <div class="form-column">
                    <div class="section-title">
                        <i class="fas fa-info-circle"></i> Informations générales
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-tag"></i> Libellé du frais
                        </label>
                        <input type="text" name="libelle" class="form-control @error('libelle') is-invalid @enderror" 
                               value="{{ old('libelle') }}" placeholder="Ex: Minerval, Scolarité, Transport" required>
                        @error('libelle') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-align-left"></i> Description
                        </label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3" placeholder="Description détaillée du frais (optionnel)">{{ old('description') }}</textarea>
                        @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-building"></i> Classe concernée
                        </label>
                        <select name="classe_id" class="form-control @error('classe_id') is-invalid @enderror" required>
                            <option value="">Sélectionner une classe</option>
                            @foreach($classes as $classe)
                                <option value="{{ $classe->id_classe }}" {{ old('classe_id') == $classe->id_classe ? 'selected' : '' }}>
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
                        <i class="fas fa-money-bill-wave"></i> Montant et devise
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-money-bill"></i> Montant
                            </label>
                            <input type="number" name="montant" class="form-control @error('montant') is-invalid @enderror" 
                                   value="{{ old('montant') }}" placeholder="0" step="1" required>
                            @error('montant') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-dollar-sign"></i> Devise
                            </label>
                            <div class="devise-selector">
                                <label class="devise-option">
                                    <input type="radio" name="devise" value="FC" {{ old('devise', 'FC') == 'FC' ? 'checked' : '' }} required>
                                    <span class="devise-card devise-fc">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <strong>FC</strong>
                                        <small>Franc Congolais</small>
                                    </span>
                                </label>
                                <label class="devise-option">
                                    <input type="radio" name="devise" value="USD" {{ old('devise') == 'USD' ? 'checked' : '' }}>
                                    <span class="devise-card devise-usd">
                                        <i class="fas fa-dollar-sign"></i>
                                        <strong>USD</strong>
                                        <small>Dollar US</small>
                                    </span>
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
                            <input type="number" name="penalite" class="form-control @error('penalite') is-invalid @enderror" 
                                   value="{{ old('penalite', 0) }}" placeholder="0" step="1">
                            <small class="form-hint">Montant de la pénalité en cas de retard de paiement</small>
                            @error('penalite') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-calendar-alt"></i> Date d'échéance
                            </label>
                            <input type="date" name="date_echeance" class="form-control @error('date_echeance') is-invalid @enderror" 
                                   value="{{ old('date_echeance') }}" required>
                            @error('date_echeance') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-calendar-week"></i> Périodicité
                        </label>
                        <div class="periodicite-selector">
                            <label class="periodicite-option">
                                <input type="radio" name="periodicite" value="mensuel" {{ old('periodicite') == 'mensuel' ? 'checked' : '' }}>
                                <span class="periodicite-card">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Mensuel</span>
                                </span>
                            </label>
                            <label class="periodicite-option">
                                <input type="radio" name="periodicite" value="trimestriel" {{ old('periodicite') == 'trimestriel' ? 'checked' : '' }}>
                                <span class="periodicite-card">
                                    <i class="fas fa-calendar-week"></i>
                                    <span>Trimestriel</span>
                                </span>
                            </label>
                            <label class="periodicite-option">
                                <input type="radio" name="periodicite" value="semestriel" {{ old('periodicite') == 'semestriel' ? 'checked' : '' }}>
                                <span class="periodicite-card">
                                    <i class="fas fa-calendar-half"></i>
                                    <span>Semestriel</span>
                                </span>
                            </label>
                            <label class="periodicite-option">
                                <input type="radio" name="periodicite" value="annuel" {{ old('periodicite', 'annuel') == 'annuel' ? 'checked' : '' }}>
                                <span class="periodicite-card">
                                    <i class="fas fa-calendar-year"></i>
                                    <span>Annuel</span>
                                </span>
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
                                <input type="radio" name="statut" value="actif" {{ old('statut', 'actif') == 'actif' ? 'checked' : '' }}>
                                <span class="status-badge status-active">Actif</span>
                            </label>
                            <label class="status-option">
                                <input type="radio" name="statut" value="inactif" {{ old('statut') == 'inactif' ? 'checked' : '' }}>
                                <span class="status-badge status-inactive">Inactif</span>
                            </label>
                        </div>
                        @error('statut') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="info-box">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>À savoir</strong><br>
                    Les frais peuvent être définis en FC (Franc Congolais) ou USD (Dollar US).<br>
                    La pénalité sera automatiquement appliquée après la date d'échéance.<br>
                    Le montant peut être saisi sans aucune limite (minimum 0).
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Créer le frais
                </button>
                <a href="{{ route('comptable.frais.index') }}" class="btn-outline">
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

    .form-container { padding: 25px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 5px; }
    .form-group { margin-bottom: 20px; }
    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #10b981;
    }
    .section-title i { margin-right: 8px; color: #10b981; }
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
    textarea.form-control { resize: vertical; }
    .form-hint {
        display: block;
        font-size: 11px;
        color: #64748b;
        margin-top: 5px;
    }
    .invalid-feedback { display: block; color: #ef4444; font-size: 11px; margin-top: 5px; }

    /* Devise Selector */
    .devise-selector { display: flex; gap: 15px; }
    .devise-option { cursor: pointer; flex: 1; }
    .devise-option input { display: none; }
    .devise-option input:checked + .devise-card { border-color: #10b981; background: #ecfdf5; transform: scale(1.02); }
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
    .devise-card i { font-size: 28px; }
    .devise-card strong { font-size: 18px; }
    .devise-card small { font-size: 10px; color: #64748b; }
    .devise-fc i { color: #10b981; }
    .devise-usd i { color: #f59e0b; }

    /* Périodicité Selector */
    .periodicite-selector { display: flex; flex-wrap: wrap; gap: 10px; }
    .periodicite-option { cursor: pointer; }
    .periodicite-option input { display: none; }
    .periodicite-option input:checked + .periodicite-card { background: #10b981; color: white; border-color: #10b981; }
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
    .periodicite-card:hover { border-color: #10b981; }

    /* Status Selector */
    .status-selector { display: flex; gap: 15px; }
    .status-option { cursor: pointer; }
    .status-option input { display: none; }
    .status-option input:checked + .status-badge { opacity: 1; transform: scale(1.05); }
    .status-badge {
        display: inline-block;
        padding: 8px 20px;
        font-size: 13px;
        font-weight: 500;
        opacity: 0.6;
        transition: all 0.3s;
    }
    .status-active { background: #d1fae5; color: #059669; }
    .status-inactive { background: #fee2e2; color: #dc2626; }

    .info-box {
        background: #eff6ff;
        padding: 15px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        border-left: 3px solid #3b82f6;
        margin: 20px 0;
    }
    .info-box i { color: #3b82f6; font-size: 20px; }
    .info-box div { font-size: 13px; color: #1e293b; }

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
        .devise-selector { flex-direction: column; }
        .periodicite-selector { flex-direction: column; }
        .form-actions { flex-direction: column; }
        .btn-primary, .btn-outline { justify-content: center; }
    }
</style>
@endpush
@endsection