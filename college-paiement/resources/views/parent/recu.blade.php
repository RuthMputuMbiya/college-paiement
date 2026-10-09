{{-- resources/views/parent/recu.blade.php --}}
@extends('layouts.parent')

@section('title', 'Reçu de paiement')
@section('page-title', 'Reçu de paiement')
@section('page-subtitle', 'Justificatif de votre transaction')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="receipt-card" id="receiptContent">
        <!-- En-tête du reçu -->
        <div class="receipt-header">
            <div class="school-logo">
                <i class="fas fa-school"></i>
            </div>
            <div class="school-info">
                <h2>Collège Notre-Dame de Grâce</h2>
                <p>Lubumbashi, République Démocratique du Congo</p>
                <p><i class="fas fa-phone"></i> +243 123 456 789 | <i class="fas fa-envelope"></i> info@college-ndg.cd</p>
            </div>
        </div>

        <div class="receipt-title">
            <h3>REÇU DE PAIEMENT</h3>
            <div class="receipt-number">N° {{ $paiement->reference }}</div>
        </div>

        <div class="receipt-body">
            <div class="info-grid">
                <div class="info-group">
                    <div class="info-label">Date du paiement</div>
                    <div class="info-value">{{ $paiement->created_at->format('d/m/Y à H:i') }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Référence transaction</div>
                    <div class="info-value">{{ $paiement->reference }}</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Opérateur</div>
                    <div class="info-value">{{ ucfirst($paiement->operateur) }} Money</div>
                </div>
                <div class="info-group">
                    <div class="info-label">Numéro de transaction</div>
                    <div class="info-value">{{ $paiement->code_transaction ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="separator"></div>

            <div class="info-group">
                <div class="info-label">Parent / Tuteur</div>
                <div class="info-value">{{ $paiement->parent->name ?? 'N/A' }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Élève</div>
                <div class="info-value">{{ $paiement->eleve->prenom ?? '' }} {{ $paiement->eleve->nom ?? '' }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Classe</div>
                <div class="info-value">{{ $paiement->eleve->classe->nom_classe ?? 'N/A' }}</div>
            </div>

            <div class="info-group">
                <div class="info-label">Frais</div>
                <div class="info-value">{{ $paiement->frais->libelle ?? 'N/A' }}</div>
            </div>

            <div class="separator"></div>

            <div class="amount-row">
                <div class="amount-label">Montant payé</div>
                <div class="amount-value">{{ number_format($paiement->montant, 0, ',', ' ') }} {{ $paiement->devise ?? 'FC' }}</div>
            </div>

            @if($paiement->frais && $paiement->frais->penalite > 0 && $paiement->frais->isDepasse())
            <div class="penalite-row">
                <div class="penalite-label">Dont pénalité de retard</div>
                <div class="penalite-value">{{ number_format($paiement->frais->penalite, 0, ',', ' ') }} {{ $paiement->devise ?? 'FC' }}</div>
            </div>
            @endif

            <div class="total-row">
                <div class="total-label">TOTAL</div>
                <div class="total-value">{{ number_format($paiement->montant, 0, ',', ' ') }} {{ $paiement->devise ?? 'FC' }}</div>
            </div>

            <div class="separator"></div>

            <div class="status-row">
                <div class="status-label">Statut du paiement</div>
                <div class="status-value status-{{ $paiement->statut }}">
                    <i class="fas {{ $paiement->statut == 'valide' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                    {{ $paiement->statut == 'valide' ? 'VALIDÉ' : 'EN ATTENTE' }}
                </div>
            </div>

            <div class="signature">
                <div class="signature-line"></div>
                <p>Signature du Collège Notre-Dame de Grâce</p>
            </div>
        </div>

        <div class="receipt-footer">
            <p>Ce reçu fait foi de paiement. Merci de votre confiance.</p>
            <p>Généré le {{ now()->format('d/m/Y à H:i') }}</p>
        </div>
    </div>

    <div class="action-buttons">
        <button onclick="window.print()" class="btn-print">
            <i class="fas fa-print"></i> Imprimer
        </button>
        <a href="{{ route('parent.recu.download', $paiement->id_paiement) }}" class="btn-download">
            <i class="fas fa-file-pdf"></i> Télécharger PDF
        </a>
        <a href="{{ route('parent.dashboard') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

</div>

@push('styles')
<style>
    .receipt-card {
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 30px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
    }
    .receipt-header {
        background: linear-gradient(135deg, #6b21a5 0%, #7e22ce 100%);
        padding: 30px;
        text-align: center;
        color: white;
    }
    .school-logo {
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }
    .school-logo i {
        font-size: 32px;
    }
    .school-info h2 {
        font-size: 20px;
        font-weight: 700;
        margin: 0 0 5px 0;
    }
    .school-info p {
        font-size: 12px;
        opacity: 0.8;
        margin: 3px 0;
    }

    .receipt-title {
        text-align: center;
        padding: 20px;
        border-bottom: 2px solid #e2e8f0;
    }
    .receipt-title h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        letter-spacing: 2px;
    }
    .receipt-number {
        font-size: 12px;
        color: #64748b;
        margin-top: 5px;
        font-family: monospace;
    }

    .receipt-body {
        padding: 30px;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        margin-bottom: 20px;
    }
    .info-group {
        margin-bottom: 10px;
    }
    .info-label {
        font-size: 11px;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
    }
    .info-value {
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
    }

    .separator {
        height: 1px;
        background: #e2e8f0;
        margin: 20px 0;
    }

    .amount-row, .penalite-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
    }
    .amount-label, .penalite-label {
        font-size: 13px;
        color: #64748b;
    }
    .amount-value, .penalite-value {
        font-size: 13px;
        font-weight: 500;
        color: #1e293b;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        padding: 15px 0;
        border-top: 2px solid #e2e8f0;
        margin-top: 10px;
    }
    .total-label {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }
    .total-value {
        font-size: 20px;
        font-weight: 800;
        color: #7e22ce;
    }

    .status-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background: #f8fafc;
        margin: 20px 0;
    }
    .status-label {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
    }
    .status-value {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 5px 15px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-valide {
        background: #d1fae5;
        color: #059669;
    }
    .status-en_attente {
        background: #fef3c7;
        color: #d97706;
    }

    .signature {
        text-align: center;
        margin-top: 30px;
    }
    .signature-line {
        width: 200px;
        height: 1px;
        background: #cbd5e1;
        margin: 0 auto 10px;
    }
    .signature p {
        font-size: 11px;
        color: #94a3b8;
        margin: 0;
    }

    .receipt-footer {
        background: #f8fafc;
        padding: 15px;
        text-align: center;
        border-top: 1px solid #e2e8f0;
    }
    .receipt-footer p {
        font-size: 11px;
        color: #94a3b8;
        margin: 3px 0;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        max-width: 800px;
        margin: 0 auto;
    }
    .btn-print, .btn-download, .btn-back {
        padding: 12px 25px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        cursor: pointer;
        border: none;
    }
    .btn-print {
        background: #3b82f6;
        color: white;
    }
    .btn-print:hover {
        background: #2563eb;
        transform: translateY(-2px);
    }
    .btn-download {
        background: #ef4444;
        color: white;
    }
    .btn-download:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }
    .btn-back {
        background: #f1f5f9;
        color: #64748b;
    }
    .btn-back:hover {
        background: #e2e8f0;
    }

    @media print {
        .action-buttons, .top-bar, .parent-sidebar, .btn-menu-mobile, .date-badge {
            display: none !important;
        }
        .parent-main {
            margin: 0 !important;
            padding: 0 !important;
        }
        .receipt-card {
            box-shadow: none;
            margin: 0;
        }
    }

    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        .action-buttons {
            flex-direction: column;
        }
        .btn-print, .btn-download, .btn-back {
            justify-content: center;
        }
    }
</style>
@endpush
@endsection