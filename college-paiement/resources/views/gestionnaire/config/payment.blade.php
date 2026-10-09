{{-- resources/views/gestionnaire/config/payment.blade.php --}}
@extends('layouts.gestionnaire')

@section('title', 'Configuration paiement')
@section('page-title', 'Configuration des paiements')
@section('page-subtitle', 'Paramètres des opérateurs Mobile Money')

@section('content')
<div class="stats-grid">
    @foreach($operateurs as $operateur)
    <div class="stat-card">
        <div class="stat-icon" style="background: {{ $operateur->operateur == 'airtel' ? '#fee2e2' : ($operateur->operateur == 'orange' ? '#fef3c7' : '#d1fae5') }}; color: {{ $operateur->operateur == 'airtel' ? '#dc2626' : ($operateur->operateur == 'orange' ? '#d97706' : '#059669') }};">
            <i class="fas {{ $operateur->operateur == 'airtel' ? 'fa-signal' : ($operateur->operateur == 'orange' ? 'fa-circle' : 'fa-charging-station') }} fa-2x"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">{{ ucfirst($operateur->operateur) }} Money</div>
            <div class="stat-value">{{ $operateur->statut == 'actif' ? 'Actif' : 'Inactif' }}</div>
            <div style="font-size: 11px;">Délai: {{ $operateur->delai_simulation_ms }}ms</div>
        </div>
    </div>
    @endforeach
</div>

<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-credit-card"></i> Configuration par opérateur</h3>
    </div>
    <div class="card-body">
        @foreach($operateurs as $operateur)
        <form method="POST" action="{{ route('gestionnaire.payment-config.update', $operateur->id_config) }}" style="margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e2e8f0;">
            @csrf @method('PUT')
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px;">
                <div><strong>{{ ucfirst($operateur->operateur) }} Money</strong></div>
                <select name="statut" class="form-control" style="width: auto; min-width: 120px;">
                    <option value="actif" {{ $operateur->statut == 'actif' ? 'selected' : '' }}>Actif</option>
                    <option value="inactif" {{ $operateur->statut == 'inactif' ? 'selected' : '' }}>Inactif</option>
                </select>
                <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Mettre à jour</button>
            </div>
        </form>
        @endforeach
    </div>
</div>
@endsection