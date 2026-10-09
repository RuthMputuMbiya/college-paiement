{{-- resources/views/comptable/classes/edit.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Modifier la classe')
@section('page-title', 'Modifier la classe')
@section('page-subtitle', 'Modifier les informations de la classe')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="form-card">
        <div class="form-header">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h3>Modifier la classe</h3>
                    <p>ID: {{ $classe->id_classe }} - {{ $classe->nom_classe }}</p>
                </div>
            </div>
            <a href="{{ route('comptable.classes.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('comptable.classes.update', $classe->id_classe) }}" class="form-container">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-column">
                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-tag"></i> Nom de la classe
                        </label>
                        <input type="text" name="nom_classe" class="form-control @error('nom_classe') is-invalid @enderror" 
                               value="{{ old('nom_classe', $classe->nom_classe) }}" placeholder="Ex: 6ème A, 5ème B" required>
                        @error('nom_classe')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-graduation-cap"></i> Niveau
                        </label>
                        <div class="niveau-selector">
                            <label class="niveau-option">
                                <input type="radio" name="niveau" value="Maternelle" {{ old('niveau', $classe->niveau) == 'Maternelle' ? 'checked' : '' }} required>
                                <div class="niveau-card niveau-maternelle">
                                    <div class="niveau-icon"><i class="fas fa-baby-carriage"></i></div>
                                    <div class="niveau-info">
                                        <span class="niveau-name">Maternelle</span>
                                        <small>Petite, Moyenne, Grande section</small>
                                    </div>
                                </div>
                            </label>
                            <label class="niveau-option">
                                <input type="radio" name="niveau" value="Primaire" {{ old('niveau', $classe->niveau) == 'Primaire' ? 'checked' : '' }}>
                                <div class="niveau-card niveau-primaire">
                                    <div class="niveau-icon"><i class="fas fa-book-open"></i></div>
                                    <div class="niveau-info">
                                        <span class="niveau-name">Primaire</span>
                                        <small>1ère à 6ème année</small>
                                    </div>
                                </div>
                            </label>
                            <label class="niveau-option">
                                <input type="radio" name="niveau" value="Secondaire" {{ old('niveau', $classe->niveau) == 'Secondaire' ? 'checked' : '' }}>
                                <div class="niveau-card niveau-secondaire">
                                    <div class="niveau-icon"><i class="fas fa-chalkboard-user"></i></div>
                                    <div class="niveau-info">
                                        <span class="niveau-name">Secondaire</span>
                                        <small>7ème à 12ème année</small>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('niveau')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-calendar"></i> Année scolaire
                        </label>
                        <select name="annee_scolaire" class="form-control @error('annee_scolaire') is-invalid @enderror" required>
                            <option value="">Sélectionnez une année</option>
                            <option value="2024-2025" {{ old('annee_scolaire', $classe->annee_scolaire) == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                            <option value="2025-2026" {{ old('annee_scolaire', $classe->annee_scolaire) == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                            <option value="2026-2027" {{ old('annee_scolaire', $classe->annee_scolaire) == '2026-2027' ? 'selected' : '' }}>2026-2027</option>
                        </select>
                        @error('annee_scolaire')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-users"></i> Capacité maximale
                        </label>
                        <div class="capacity-input">
                            <input type="number" name="capacite" class="form-control @error('capacite') is-invalid @enderror" 
                                   value="{{ old('capacite', $classe->capacite) }}" min="1" max="100" required>
                            <span class="capacity-unit">élèves</span>
                        </div>
                        <small class="form-hint">
                            <i class="fas fa-info-circle"></i> Capacité actuelle: <strong>{{ $classe->capacite }}</strong> places
                        </small>
                        @error('capacite')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-align-left"></i> Description
                        </label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="4" placeholder="Description de la classe (optionnel)">{{ old('description', $classe->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="info-stats">
                        <div class="stat-item">
                            <div class="stat-icon"><i class="fas fa-child"></i></div>
                            <div class="stat-content">
                                <span class="stat-label">Effectif actuel</span>
                                <span class="stat-value">{{ $classe->effectif }} élèves</span>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon"><i class="fas fa-chart-line"></i></div>
                            <div class="stat-content">
                                <span class="stat-label">Taux de remplissage</span>
                                <span class="stat-value">{{ $classe->taux_remplissage }}%</span>
                                <div class="progress-bar-mini">
                                    <div class="progress-fill" style="width: {{ $classe->taux_remplissage }}%; background: {{ $classe->taux_remplissage >= 80 ? '#ef4444' : ($classe->taux_remplissage >= 60 ? '#f59e0b' : '#10b981') }}"></div>
                                </div>
                            </div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                            <div class="stat-content">
                                <span class="stat-label">Année scolaire</span>
                                <span class="stat-value">{{ $classe->annee_scolaire }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Mettre à jour
                </button>
                <a href="{{ route('comptable.classes.show', $classe->id_classe) }}" class="btn-outline">
                    <i class="fas fa-eye"></i> Voir les détails
                </a>
                <a href="{{ route('comptable.classes.index') }}" class="btn-outline">
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
    textarea.form-control {
        resize: vertical;
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
    /* NIVEAU SELECTOR */
    /* ========================================== */
    .niveau-selector {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 5px;
    }
    .niveau-option {
        cursor: pointer;
    }
    .niveau-option input {
        display: none;
    }
    .niveau-option input:checked + .niveau-card {
        border-color: #10b981;
        background: #ecfdf5;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(16,185,129,0.15);
    }
    .niveau-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s;
        cursor: pointer;
    }
    .niveau-card:hover {
        border-color: #10b981;
        transform: translateY(-2px);
    }
    .niveau-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }
    .niveau-maternelle .niveau-icon {
        background: #fdf2f8;
        color: #ec4899;
    }
    .niveau-primaire .niveau-icon {
        background: #eff6ff;
        color: #3b82f6;
    }
    .niveau-secondaire .niveau-icon {
        background: #f5f3ff;
        color: #8b5cf6;
    }
    .niveau-icon i {
        font-size: 20px;
    }
    .niveau-info {
        flex: 1;
    }
    .niveau-name {
        display: block;
        font-weight: 700;
        font-size: 14px;
        color: #1e293b;
    }
    .niveau-info small {
        display: block;
        font-size: 10px;
        color: #64748b;
    }

    /* ========================================== */
    /* CAPACITY INPUT */
    /* ========================================== */
    .capacity-input {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .capacity-input .form-control {
        flex: 1;
    }
    .capacity-unit {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }

    /* ========================================== */
    /* INFO STATS */
    /* ========================================== */
    .info-stats {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 20px;
        margin-top: 20px;
        border: 1px solid #e2e8f0;
    }
    .stat-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 10px 0;
        border-bottom: 1px solid #e2e8f0;
    }
    .stat-item:last-child {
        border-bottom: none;
    }
    .stat-icon {
        width: 40px;
        height: 40px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #10b981;
        font-size: 18px;
        border-radius: 10px;
    }
    .stat-content {
        flex: 1;
    }
    .stat-label {
        display: block;
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-value {
        display: block;
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }
    .progress-bar-mini {
        margin-top: 8px;
        background: #e2e8f0;
        height: 4px;
        overflow: hidden;
        border-radius: 2px;
    }
    .progress-fill {
        height: 100%;
        transition: width 0.3s;
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
            gap: 0;
        }
        .niveau-selector {
            grid-template-columns: 1fr;
            gap: 10px;
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