{{-- resources/views/pdf/recu_comptable.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reçu de paiement - Collège Notre-Dame de Grâce</title>
    <style>
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
        
        /* Container principal */
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        /* En-tête avec logo */
        .header {
            background: linear-gradient(135deg, #0F2B3D 0%, #1A4058 100%);
            padding: 30px;
            text-align: center;
            color: white;
            position: relative;
        }
        
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .logo-circle {
            width: 80px;
            height: 80px;
            background: rgba(212, 175, 55, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #D4AF37;
        }
        
        .logo-circle i {
            font-size: 40px;
            color: #D4AF37;
        }
        
        .header h1 {
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 5px 0;
            letter-spacing: 1px;
        }
        
        .header .subtitle {
            font-size: 11px;
            opacity: 0.8;
            letter-spacing: 2px;
        }
        
        .header address {
            font-size: 10px;
            opacity: 0.7;
            margin-top: 10px;
            font-style: normal;
        }
        
        /* Titre du reçu */
        .receipt-title {
            text-align: center;
            padding: 20px;
            background: #FAFAFA;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .receipt-title h2 {
            font-size: 18px;
            font-weight: 700;
            color: #D4AF37;
            margin: 0;
            letter-spacing: 3px;
        }
        
        .receipt-number {
            font-size: 11px;
            color: #64748b;
            margin-top: 8px;
            font-family: monospace;
            background: #f1f5f9;
            display: inline-block;
            padding: 4px 12px;
        }
        
        /* Corps */
        .content {
            padding: 25px 30px;
        }
        
        /* Infos du payeur et école */
        .payeur-section {
            background: #f8fafc;
            padding: 15px 20px;
            margin-bottom: 25px;
            border-left: 4px solid #D4AF37;
        }
        
        .payeur-section h4 {
            font-size: 12px;
            color: #D4AF37;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 12px;
        }
        
        .payeur-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        
        .payeur-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .payeur-item i {
            width: 20px;
            color: #D4AF37;
            font-size: 12px;
        }
        
        .payeur-item span {
            font-size: 11px;
            color: #1e293b;
        }
        
        .payeur-item strong {
            font-weight: 600;
            color: #0F2B3D;
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
            padding: 12px 15px;
            border-left: 3px solid #D4AF37;
        }
        
        .info-label {
            display: block;
            font-size: 9px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        
        .info-value {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #0F2B3D;
        }
        
        /* Séparateur */
        .separator {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 20px 0;
        }
        
        /* Détails du paiement */
        .details-title {
            font-size: 13px;
            font-weight: 700;
            color: #0F2B3D;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .details-title i {
            color: #D4AF37;
            margin-right: 8px;
        }
        
        .details-table {
            width: 100%;
            margin: 15px 0;
            border-collapse: collapse;
        }
        
        .details-table tr {
            border-bottom: 1px solid #f1f5f9;
        }
        
        .details-table td {
            padding: 10px 0;
        }
        
        .details-table .label {
            color: #64748b;
            font-size: 11px;
        }
        
        .details-table .value {
            font-weight: 600;
            font-size: 11px;
            color: #0F2B3D;
            text-align: right;
        }
        
        /* Total */
        .total-box {
            background: linear-gradient(135deg, #0F2B3D 0%, #1A4058 100%);
            padding: 18px 25px;
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .total-label {
            font-size: 14px;
            font-weight: 700;
            color: white;
            letter-spacing: 1px;
        }
        
        .total-value {
            font-size: 22px;
            font-weight: 800;
            color: #D4AF37;
        }
        
        /* Statut */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 20px;
            font-size: 12px;
            font-weight: 600;
            background: #d1fae5;
            color: #059669;
        }
        
        /* Signature */
        .signature {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px dashed #e2e8f0;
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
        
        /* Footer */
        .footer {
            background: #0F2B3D;
            padding: 15px 25px;
            text-align: center;
            border-top: 1px solid #1A4058;
        }
        
        .footer p {
            font-size: 9px;
            color: rgba(255,255,255,0.6);
            margin: 3px 0;
        }
        
        /* Badge opérateur */
        .operator-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 8px;
            font-size: 10px;
            font-weight: 500;
        }
        .operator-airtel { background: #fee2e2; color: #dc2626; }
        .operator-orange { background: #fef3c7; color: #d97706; }
        .operator-mpesa { background: #d1fae5; color: #059669; }
        
        @media print {
            body {
                padding: 0;
                margin: 0;
                background: white;
            }
            .receipt-container {
                box-shadow: none;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- En-tête avec logo -->
        <div class="header">
            <div class="logo-container">
                <div class="logo-circle">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
            <h1>Collège Notre-Dame de Grâce</h1>
            <div class="subtitle">ÉTABLISSEMENT D'EXCELLENCE</div>
            <address>
                Lubumbashi, République Démocratique du Congo<br>
                                📞 +243 999 888 777 | ✉️ info@collegendg.com
            </address>
        </div>
        
        <!-- Titre du reçu -->
        <div class="receipt-title">
            <h2>REÇU OFFICIEL DE PAIEMENT</h2>
            <div class="receipt-number">📄 N° {{ $paiement->reference }}</div>
        </div>
        
        <!-- Corps -->
        <div class="content">
            
            <!-- Section Payeur -->
            <div class="payeur-section">
                <h4><i class="fas fa-user-check"></i> INFORMATIONS DU PAYEUR</h4>
                <div class="payeur-info">
                    <div class="payeur-item">
                        <i class="fas fa-user"></i>
                        <span><strong>Parent :</strong> {{ $paiement->parent->name ?? 'N/A' }}</span>
                    </div>
                    <div class="payeur-item">
                        <i class="fas fa-envelope"></i>
                        <span><strong>Email :</strong> {{ $paiement->parent->email ?? 'N/A' }}</span>
                    </div>
                    <div class="payeur-item">
                        <i class="fas fa-user-graduate"></i>
                        <span><strong>Élève :</strong> {{ $paiement->eleve->prenom ?? '' }} {{ $paiement->eleve->nom ?? '' }}</span>
                    </div>
                    <div class="payeur-item">
                        <i class="fas fa-school"></i>
                        <span><strong>Classe :</strong> {{ $paiement->eleve->classe->nom_classe ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
            
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
            </div>
            
            <div class="separator"></div>
            
            <!-- Détails du paiement -->
            <div class="details-title">
                <i class="fas fa-receipt"></i> DÉTAILS DE LA TRANSACTION
            </div>
            
            <table class="details-table">
                <tr>
                    <td class="label">📋 Type de frais</td>
                    <td class="value">{{ $paiement->frais->libelle ?? 'Frais scolaire' }}</td>
                </tr>
                <tr>
                    <td class="label">📱 Opérateur Mobile Money</td>
                    <td class="value">
                        <span class="operator-badge operator-{{ $paiement->operateur }}">
                            <i class="fas {{ $paiement->operateur == 'airtel' ? 'fa-signal' : ($paiement->operateur == 'orange' ? 'fa-circle' : 'fa-charging-station') }}"></i>
                            {{ ucfirst($paiement->operateur) }} Money
                        </span>
                    </td>
                </tr>
                <tr>
                    <td class="label">📞 Numéro de téléphone</td>
                    <td class="value">+243 {{ $paiement->numero_mobile ?? 'N/A' }}</td>
                </tr>
            </table>
            
            <div class="separator"></div>
            
            <!-- Total -->
            <div class="total-box">
                <span class="total-label">💰 MONTANT TOTAL PAYÉ</span>
                <span class="total-value">
                    @if($paiement->devise == 'USD')
                        {{ number_format($paiement->montant, 2, ',', ' ') }} USD
                    @else
                        {{ number_format($paiement->montant, 0, ',', ' ') }} FC
                    @endif
                </span>
            </div>
            
            <!-- Statut -->
            <div style="text-align: center; margin: 15px 0;">
                <span class="status-badge">
                    <i class="fas fa-check-circle"></i> PAIEMENT VALIDÉ
                </span>
            </div>
            
            <!-- Signature -->
            <div class="signature">
                <div class="signature-line"></div>
                <p>Signature du Collège Notre-Dame de Grâce</p>
                <p>🏛️ Cachet officiel de l'établissement</p>
                <p style="font-size: 8px; margin-top: 8px;">Ce document fait office de reçu officiel et justificatif de paiement</p>
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
            <p style="margin-top: 5px;">Collège Notre-Dame de Grâce - L'éducation au cœur de l'excellence</p>
        </div>
    </div>
</body>
</html>