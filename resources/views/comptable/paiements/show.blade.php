{{-- resources/views/comptable/paiements/show.blade.php --}}
@extends('layouts.comptable')

@section('title', 'Détails du paiement')
@section('page-title', 'Détails du paiement')
@section('page-subtitle', 'Consultez les informations complètes de la transaction')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <!-- Bouton retour -->
    <div class="mb-4">
        <a href="{{ route('comptable.paiements.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Détails du paiement -->
            <div class="detail-card mb-4">
                <div class="detail-header">
                    <h3><i class="fas fa-receipt"></i> Informations du paiement</h3>
                    <span class="payment-status status-{{ $paiement->statut }}">
                        <i class="fas {{ $paiement->statut == 'valide' ? 'fa-check-circle' : ($paiement->statut == 'en_attente' ? 'fa-clock' : 'fa-times-circle') }}"></i>
                        {{ $paiement->statut == 'valide' ? 'Validé' : ($paiement->statut == 'en_attente' ? 'En attente' : 'Échoué') }}
                    </span>
                </div>
                <div class="detail-body">
                    <div class="info-row">
                        <div class="info-label">Référence</div>
                        <div class="info-value">{{ $paiement->reference }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Date du paiement</div>
                        <div class="info-value">
                            @php
                                $dateLubumbashi = \Carbon\Carbon::parse($paiement->created_at)->setTimezone('Africa/Lubumbashi');
                            @endphp
                            {{ $dateLubumbashi->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Code transaction</div>
                        <div class="info-value">{{ $paiement->code_transaction ?? 'Non disponible' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Montant</div>
                        <div class="info-value amount">
                            @if($paiement->devise == 'USD')
                                {{ number_format($paiement->montant, 2, ',', ' ') }} USD
                            @else
                                {{ number_format($paiement->montant, 0, ',', ' ') }} FC
                            @endif
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Opérateur</div>
                        <div class="info-value">
                            <span class="operator-badge operator-{{ $paiement->operateur }}">
                                <i class="fas {{ $paiement->operateur == 'airtel' ? 'fa-signal' : ($paiement->operateur == 'orange' ? 'fa-circle' : 'fa-charging-station') }}"></i>
                                {{ ucfirst($paiement->operateur) }} Money
                            </span>
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Numéro mobile</div>
                        <div class="info-value">+243 {{ $paiement->numero_mobile ?? 'Non renseigné' }}</div>
                    </div>
                </div>
            </div>

            <!-- Informations de l'élève -->
            <div class="detail-card mb-4">
                <div class="detail-header">
                    <h3><i class="fas fa-user-graduate"></i> Informations de l'élève</h3>
                </div>
                <div class="detail-body">
                    <div class="info-row">
                        <div class="info-label">Nom complet</div>
                        <div class="info-value">{{ $paiement->eleve->prenom ?? '' }} {{ $paiement->eleve->nom ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Classe</div>
                        <div class="info-value">{{ $paiement->eleve->classe->nom_classe ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Niveau</div>
                        <div class="info-value">{{ $paiement->eleve->classe->niveau ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <!-- Informations du frais -->
            <div class="detail-card mb-4">
                <div class="detail-header">
                    <h3><i class="fas fa-money-bill-wave"></i> Informations du frais</h3>
                </div>
                <div class="detail-body">
                    <div class="info-row">
                        <div class="info-label">Libellé</div>
                        <div class="info-value">{{ $paiement->frais->libelle ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Description</div>
                        <div class="info-value">{{ $paiement->frais->description ?? 'Aucune description' }}</div>
                    </div>
                    @if($paiement->frais->date_echeance)
                    <div class="info-row">
                        <div class="info-label">Date d'échéance</div>
                        <div class="info-value">{{ \Carbon\Carbon::parse($paiement->frais->date_echeance)->format('d/m/Y') }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Informations du parent -->
            <div class="detail-card mb-4">
                <div class="detail-header">
                    <h3><i class="fas fa-user"></i> Parent</h3>
                </div>
                <div class="detail-body">
                    <div class="info-row">
                        <div class="info-label">Nom</div>
                        <div class="info-value">{{ $paiement->parent->name ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $paiement->parent->email ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="detail-card">
                <div class="detail-header">
                    <h3><i class="fas fa-cogs"></i> Actions</h3>
                </div>
                <div class="detail-body">
                    <div class="action-buttons-vertical">
                        <a href="{{ route('comptable.paiements.receipt', $paiement->id_paiement) }}" class="btn-action receipt" target="_blank">
                            <i class="fas fa-file-pdf"></i> Télécharger le reçu
                        </a>
                        @if($paiement->statut == 'en_attente')
                            <button onclick="validatePayment({{ $paiement->id_paiement }})" class="btn-action validate">
                                <i class="fas fa-check-circle"></i> Valider le paiement
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Simulation API -->
            @if($paiement->simulation)
            <div class="detail-card mt-4">
                <div class="detail-header">
                    <h3><i class="fas fa-code-branch"></i> Traces API</h3>
                </div>
                <div class="detail-body">
                    <div class="info-row">
                        <div class="info-label">Statut requête</div>
                        <div class="info-value">{{ $paiement->simulation->statut ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row">
                        <div class="info-label">Temps réponse</div>
                        <div class="info-value">{{ $paiement->simulation->temps_reponse_ms ?? 'N/A' }} ms</div>
                    </div>
                    <button class="btn-toggle-json" onclick="toggleJson()">
                        <i class="fas fa-code"></i> Voir les détails techniques
                    </button>
                    <div id="jsonDetails" style="display: none; margin-top: 15px;">
                        <div class="json-section">
                            <div class="json-title">Requête envoyée</div>
                            <pre class="json-pre">
                                @php
                                    $requete = $paiement->simulation->requete ?? '{}';
                                    if (is_string($requete)) {
                                        $requeteDecodee = json_decode($requete, true);
                                        echo json_encode($requeteDecodee, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                    } else {
                                        echo json_encode($requete, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                    }
                                @endphp
                            </pre>
                        </div>
                        <div class="json-section mt-3">
                            <div class="json-title">Réponse reçue</div>
                            <pre class="json-pre">
                                @php
                                    $reponse = $paiement->simulation->reponse ?? '{}';
                                    if (is_string($reponse)) {
                                        $reponseDecodee = json_decode($reponse, true);
                                        echo json_encode($reponseDecodee, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                    } else {
                                        echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                                    }
                                @endphp
                            </pre>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: #f1f5f9;
        border-radius: 8px;
        color: #64748b;
        text-decoration: none;
        font-size: 13px;
        transition: all 0.2s;
    }
    .btn-back:hover {
        background: #e2e8f0;
        color: #1e293b;
    }
    .detail-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .detail-header {
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }
    .detail-header h3 {
        font-size: 16px;
        font-weight: 700;
        margin: 0;
        color: #1e293b;
    }
    .detail-header h3 i {
        margin-right: 8px;
        color: #D4AF37;
    }
    .detail-body {
        padding: 20px;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
    }
    .info-value {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        text-align: right;
    }
    .info-value.amount {
        font-size: 18px;
        color: #D4AF37;
    }
    .payment-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-valide { background: #d1fae5; color: #059669; }
    .status-en_attente { background: #fef3c7; color: #d97706; }
    .status-echoue { background: #fee2e2; color: #dc2626; }

    .operator-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .operator-airtel { background: #fee2e2; color: #dc2626; }
    .operator-orange { background: #fef3c7; color: #d97706; }
    .operator-mpesa { background: #d1fae5; color: #059669; }

    .action-buttons-vertical {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .btn-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
    }
    .btn-action.receipt {
        background: #fee2e2;
        color: #dc2626;
    }
    .btn-action.receipt:hover {
        background: #dc2626;
        color: white;
    }
    .btn-action.validate {
        background: #d1fae5;
        color: #059669;
    }
    .btn-action.validate:hover {
        background: #059669;
        color: white;
    }
    .btn-toggle-json {
        width: 100%;
        margin-top: 15px;
        padding: 8px;
        background: #f1f5f9;
        border: none;
        border-radius: 8px;
        color: #64748b;
        font-size: 12px;
        cursor: pointer;
    }
    .btn-toggle-json:hover {
        background: #e2e8f0;
    }
    .json-section {
        background: #f8fafc;
        border-radius: 8px;
        padding: 10px;
    }
    .json-title {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
        margin-bottom: 8px;
    }
    .json-pre {
        font-size: 10px;
        background: #1e293b;
        color: #a7f3d0;
        padding: 12px;
        border-radius: 6px;
        overflow-x: auto;
        font-family: monospace;
        margin: 0;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px;
    }
    .col-lg-8, .col-lg-4 {
        padding: 0 15px;
    }
    .col-lg-8 { width: 66.666%; }
    .col-lg-4 { width: 33.333%; }
    @media (max-width: 992px) {
        .col-lg-8, .col-lg-4 { width: 100%; }
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleJson() {
        const jsonDetails = document.getElementById('jsonDetails');
        if (jsonDetails.style.display === 'none' || jsonDetails.style.display === '') {
            jsonDetails.style.display = 'block';
        } else {
            jsonDetails.style.display = 'none';
        }
    }

    function validatePayment(id) {
        if(confirm('Valider ce paiement ? Cette action est irréversible.')) {
            fetch(`/comptable/paiements/${id}/validate`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json()).then(data => {
                if(data.success) {
                    location.reload();
                } else {
                    alert('Erreur lors de la validation');
                }
            }).catch(error => {
                alert('Une erreur est survenue');
            });
        }
    }
</script>
@endpush
@endsection