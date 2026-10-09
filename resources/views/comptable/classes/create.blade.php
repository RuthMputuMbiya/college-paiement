{{-- resources/views/comptable/classes/create.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Créer une classe')
@section('page-title', 'Créer une classe')
@section('page-subtitle', 'Ajouter une nouvelle classe')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="form-card">
        <div class="form-header">
            <div class="header-left">
                <i class="fas fa-plus-circle"></i>
                <div>
                    <h3>Nouvelle classe</h3>
                    <p>Remplissez les informations ci-dessous</p>
                </div>
            </div>
            <a href="{{ route('comptable.classes.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('comptable.classes.store') }}" class="form-container">
            @csrf

            <div class="form-grid">
                <div class="form-column">
                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-tag"></i> Nom de la classe
                        </label>
                        <input type="text" name="nom_classe" class="form-control @error('nom_classe') is-invalid @enderror" 
                               value="{{ old('nom_classe') }}" placeholder="Ex: 6ème A, 5ème B, 4ème C" required>
                        @error('nom_classe')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-graduation-cap"></i> Niveau
                        </label>
                        <select name="niveau" class="form-control @error('niveau') is-invalid @enderror" required>
                            <option value="">Sélectionnez un niveau</option>
                            <option value="Maternelle" {{ old('niveau') == 'Maternelle' ? 'selected' : '' }}>Maternelle</option>
                            <option value="Primaire" {{ old('niveau') == 'Primaire' ? 'selected' : '' }}>Primaire</option>
                            <option value="Lycée" {{ old('niveau') == 'Secondaire' ? 'selected' : '' }}>Secondaire</option>
                        </select>
                        @error('niveau')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-calendar"></i> Année scolaire
                        </label>
                        <select name="annee_scolaire" class="form-control @error('annee_scolaire') is-invalid @enderror" required>
                            <option value="">Sélectionnez l'année</option>
                            <option value="2024-2025" {{ old('annee_scolaire') == '2024-2025' ? 'selected' : '' }}>2024-2025</option>
                            <option value="2025-2026" {{ old('annee_scolaire') == '2025-2026' ? 'selected' : '' }}>2025-2026</option>
                            <option value="2026-2027" {{ old('annee_scolaire') == '2026-2027' ? 'selected' : '' }}>2026-2027</option>
                            <option value="2027-2028" {{ old('annee_scolaire') == '2027-2028' ? 'selected' : '' }}>2027-2028</option>
                            <option value="2028-2029" {{old('annee-scolaire')  == '2028-2029' ? 'selected' : '' }}>2028-2029</option>
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
                        <input type="number" name="capacite" class="form-control @error('capacite') is-invalid @enderror" 
                               value="{{ old('capacite', 40) }}" placeholder="Nombre d'élèves maximum" required>
                        @error('capacite')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Créer la classe
                </button>
                <a href="{{ route('comptable.classes.index') }}" class="btn-outline">
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

    .form-container { padding: 25px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
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
    textarea.form-control { resize: vertical; }
    .invalid-feedback { display: block; color: #ef4444; font-size: 11px; margin-top: 5px; }

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

    @media (max-width: 768px) {
        .form-grid { grid-template-columns: 1fr; gap: 0; }
        .form-actions { flex-direction: column; }
        .btn-primary, .btn-outline { justify-content: center; }
    }
</style>
@endpush
@endsection