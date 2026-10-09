{{-- resources/views/pdf/recu.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reçu de paiement - Collège NDG</title>
    <style>
        /* ========================================== */
        /* RESET & BASE */
        /* ========================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 30px;
            color: #1e293b;
        }
        
        /* ========================================== */
        /* CONTAINER PRINCIPAL */
        /* ========================================== */
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 35px rgba(0,0,0,0.1);
        }
        
        /* ========================================== */
        /* EN-TÊTE - Design NDG (Bleu marine + Or) */
        /* ========================================== */
        .header {
            background: linear-gradient(135deg, #0F2B3D 0%, #1A4058 100%);
            padding: 35px 30px;
            text-align: center;
            color: white;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: rgba(212, 175, 55, 0.15);
            border-radius: 50% !important;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            border: 2px solid #D4AF37;
        }
        
        .logo i {
            font-size: 38px;
            color: #D4AF37;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: 800;
            margin: 0 0 5px 0;
            letter-spacing: 1px;
            font-family: 'Playfair Display', serif;
        }
        
        .header p {
            font-size: 12px;
            opacity: 0.85;
            margin: 3px 0;
        }
        
        /* ========================================== */
        /* TITRE DU REÇU */
        /* ========================================== */
        .receipt-title {
            text-align: center;
            padding: 20px 30px;
            border-bottom: 2px solid #e2e8f0;
            background: #FAFAFA;
        }
        
        .receipt-title h2 {
            font-size: 20px;
            font-weight: 700;
            color: #D4AF37;
            margin: 0;
            letter-spacing: 3px;
        }
        
        .receipt-number {
            font-size: 12px;
            color: #64748b;
            margin-top: 8px;
            font-family: monospace;
            background: #f1f5f9;
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px !important;
        }
        
        /* ========================================== */
        /* CORPS DU REÇU */
        /* ========================================== */
        .content {
            padding: 30px;
        }
        
        /* Grille d'informations */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .info-box {
            background: #f8fafc;
            padding: 15px;
            border-left: 4px solid #D4AF37;
            border-radius: 12px !important;
        }
        
        .info-label {
            display: block;
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
        }
        
        .info-value {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #0F2B3D;
        }
        
        /* Séparateur */
        .separator {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 20px 0;
        }
        
        /* Détails du paiement */
        .details-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        
        .details-table tr {
            border-bottom: 1px solid #f1f5f9;
        }
        
        .details-table td {
            padding: 12px 0;
        }
        
        .details-table .label {
            color: #64748b;
            font-size: 13px;
            font-weight: 500;
        }
        
        .details-table .value {
            font-weight: 600;
            font-size: 13px;
            color: #0F2B3D;
            text-align: right;
        }
        
        /* Total */
        .total-box {
            background: linear-gradient(135deg, #0F2B3D 0%, #1A4058 100%);
            padding: 20px 25px;
            margin: 25px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 12px !important;
        }
        
        .total-label {
            font-size: 16px;
            font-weight: 700;
            color: white;
            letter-spacing: 1px;
        }
        
        .total-value {
            font-size: 24px;
            font-weight: 800;
            color: #D4AF37;
        }
        
        /* Statut */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 30px !important;
        }
        
        .status-valide {
            background: #d1fae5;
            color: #059669;
            border: 1px solid #a7f3d0;
        }
        
        .status-en_attente {
            background: #fef3c7;
            color: #d97706;
            border: 1px solid #fde68a;
        }
        
        /* Signature */
        .signature {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
        }
        
        .signature-line {
            width: 200px;
            height: 2px;
            background: #D4AF37;
            margin: 0 auto 10px;
        }
        
        .signature p {
            font-size: 10px;
            color: #94a3b8;
            margin: 5px 0;
        }
        
        /* ========================================== */
        /* FOOTER */
        /* ========================================== */
        .footer {
            background: #0F2B3D;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #1A4058;
        }
        
        .footer p {
            font-size: 10px;
            color: rgba(255,255,255,0.6);
            margin: 5px 0;
        }
        
        /* ========================================== */
        /* IMPRESSION */
        /* ========================================== */
        @media print {
            body {
                padding: 0;
                margin: 0;
                background: white;
            }
            .receipt-container {
                box-shadow: none;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- En-tête -->
        <div class="header">
            <div class="logo">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <h1>Collège Notre-Dame de Grâce</h1>
            <p>Lubumbashi, République Démocratique du Congo</p>
            <p style="font-size: 10px; margin-top: 5px;">📞 +243 999 888 777 | ✉️ info@collegendg.com</p>
        </div>
        
        <!-- Titre -->
        <div class="receipt-title">
            <h2>REÇU DE PAIEMENT</h2>
            <div class="receipt-number">📄 N° {{ $paiement->reference }}</div>
        </div>
        
        <!-- Corps -->
        <div class="content">
            <!-- Grille d'informations -->
            <div class="info-grid">
                <div class="info-box">
                    <span class="info-label">📅 Date du paiement</span>
                    <span class="info-value">
                        @php
                            $dateLubumbashi = \Carbon\Carbon::parse($paiement->created_at)->setTimezone('Africa/Lubumbashi');
                        @endphp
                        {{ $dateLubumbashi->format('d/m/Y à H:i') }}
                    </span>
                </div>
                <div class="info-box">
                    <span class="info-label">🔢 Code transaction</span>
                    <span class="info-value">{{ $paiement->code_transaction ?? 'N/A' }}</span>
                </div>
                <div class="info-box">
                    <span class="info-label">👨‍🎓 Élève</span>
                    <span class="info-value">{{ $paiement->eleve->prenom ?? '' }} {{ $paiement->eleve->nom ?? '' }}</span>
                </div>
                <div class="info-box">
                    <span class="info-label">🏫 Classe</span>
                    <span class="info-value">{{ $paiement->eleve->classe->nom_classe ?? 'N/A' }}</span>
                </div>
            </div>
            
            <!-- Détails du paiement -->
            <table class="details-table">
                <tr>
                    <td class="label">📋 Frais</td>
                    <td class="value">{{ $paiement->frais->libelle ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">📱 Opérateur</td>
                    <td class="value">{{ ucfirst($paiement->operateur) }} Money</td>
                </tr>
                <tr>
                    <td class="label">📞 Numéro de téléphone</td>
                    <td class="value">{{ $paiement->numero_mobile ?? 'N/A' }}</td>
                </tr>
            </table>
            
            <div class="separator"></div>
            
            <!-- Total -->
            <div class="total-box">
                <span class="total-label">💰 TOTAL PAYÉ</span>
                <span class="total-value">
                    @if($paiement->devise == 'USD')
                        {{ number_format($paiement->montant, 2, ',', ' ') }} USD
                    @else
                        {{ number_format($paiement->montant, 0, ',', ' ') }} FC
                    @endif
                </span>
            </div>
            
            <!-- Statut -->
            <div style="text-align: center; margin: 20px 0;">
                <span class="status-badge status-{{ $paiement->statut }}">
                    <i class="fas {{ $paiement->statut == 'valide' || $paiement->statut == 'PAID' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                    @if($paiement->statut == 'valide' || $paiement->statut == 'PAID')
                        ✅ Paiement validé
                    @elseif($paiement->statut == 'en_attente' || $paiement->statut == 'PENDING')
                        ⏳ En attente de validation
                    @else
                        ❌ Échoué
                    @endif
                </span>
            </div>
            
            <!-- Signature -->
            <div class="signature">
                <div class="signature-line"></div>
                <p>Signature du Collège Notre-Dame de Grâce</p>
                <p>🏛️ Cachet de l'établissement</p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>✓ Ce reçu fait foi de paiement. Merci de votre confiance.</p>
            <p>📄 Document généré automatiquement le 
                @php
                    $nowLubumbashi = \Carbon\Carbon::now('Africa/Lubumbashi');
                @endphp
                {{ $nowLubumbashi->format('d/m/Y à H:i') }}
            </p>
        </div>
    </div>
</body>
</html>