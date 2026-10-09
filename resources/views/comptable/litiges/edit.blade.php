{{-- resources/views/comptable/litiges/edit.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Traiter le litige')
@section('page-title', 'Traiter le litige')
@section('page-subtitle', 'Gestion et résolution du litige')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="form-card">
        <div class="form-header">
            <div class="header-left">
                <i class="fas fa-gavel"></i>
                <div>
                    <h3>Traiter le litige #{{ $litige->id_litige }}</h3>
                    <p>{{ $litige->paiement->reference ?? 'N/A' }} - {{ $litige->paiement->parent->name ?? 'N/A' }}</p>
                </div>
            </div>
            <a href="{{ route('comptable.litiges.show', $litige->id_litige) }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour
            </a>
        </div>

        <form method="POST" action="{{ route('comptable.litiges.update', $litige->id_litige) }}" class="form-container">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-column">
                    <div class="section-title">
                        <i class="fas fa-info-circle"></i> Informations du litige
                    </div>

                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-tag"></i> Statut
                        </label>
                        <select name="statut" class="form-control @error('statut') is-invalid @enderror" required>
                            <option value="ouvert" {{ old('statut', $litige->statut) == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                            <option value="en_cours" {{ old('statut', $litige->statut) == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="resolu" {{ old('statut', $litige->statut) == 'resolu' ? 'selected' : '' }}>Résolu</option>
                            <option value="rejete" {{ old('statut', $litige->statut) == 'rejete' ? 'selected' : '' }}>Rejeté</option>
                        </select>
                        @error('statut') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-file-alt"></i> Solution apportée
                        </label>
                        <textarea name="solution" class="form-control @error('solution') is-invalid @enderror" 
                                  rows="5" placeholder="Décrivez la solution apportée à ce litige...">{{ old('solution', $litige->solution) }}</textarea>
                        @error('solution') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="form-column">
                    <div class="section-title">
                        <i class="fas fa-receipt"></i> Informations du paiement
                    </div>

                    <div class="info-box">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <strong>Référence:</strong> {{ $litige->paiement->reference ?? 'N/A' }}<br>
                            <strong>Montant:</strong> {{ number_format($litige->paiement->montant ?? 0, 0, ',', ' ') }} {{ $litige->paiement->devise ?? 'FC' }}<br>
                            <strong>Parent:</strong> {{ $litige->paiement->parent->name ?? 'N/A' }}<br>
                            <strong>Élève:</strong> {{ $litige->paiement->eleve->prenom ?? '' }} {{ $litige->paiement->eleve->nom ?? '' }}
                        </div>
                    </div>

                    <div class="info-box-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Motif du litige</strong><br>
                            {{ $litige->motif }}
                            @if($litige->description)
                                <br><br><strong>Description:</strong><br>
                                {{ $litige->description }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
                <a href="{{ route('comptable.litiges.show', $litige->id_litige) }}" class="btn-outline">
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
        color: #f59e0b;
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
    .form-group { margin-bottom: 20px; }
    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f59e0b;
    }
    .section-title i { margin-right: 8px; color: #f59e0b; }
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
        border-color: #f59e0b;
        box-shadow: 0 0 0 2px rgba(245,158,11,0.1);
    }
    textarea.form-control { resize: vertical; }
    .invalid-feedback { display: block; color: #ef4444; font-size: 11px; margin-top: 5px; }

    .info-box {
        background: #eff6ff;
        padding: 15px;
        margin-bottom: 20px;
        border-left: 3px solid #3b82f6;
    }
    .info-box i { color: #3b82f6; font-size: 20px; margin-right: 10px; }
    .info-box-warning {
        background: #fef3c7;
        padding: 15px;
        border-left: 3px solid #f59e0b;
    }
    .info-box-warning i { color: #f59e0b; font-size: 20px; margin-right: 10px; }

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
    }
    @media (max-width: 768px) {
        .form-actions { flex-direction: column; }
        .btn-primary, .btn-outline { justify-content: center; }
    }
</style>
@endpush
@endsection