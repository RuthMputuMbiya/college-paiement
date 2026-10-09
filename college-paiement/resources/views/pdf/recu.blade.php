{{-- resources/views/pdf/recu.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reçu de paiement - Collège NDG</title>
    <style>
        /* ========================================== */
        /* RESET & BASE - COINS CARRÉS */
        /* ========================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        * {
            border-radius: 0px !important;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            background: white;
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
            border: 1px solid #e2e8f0;
        }
        
        /* ========================================== */
        /* EN-TÊTE */
        /* ========================================== */
        .header {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }
        
        .logo {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }
        
        .logo i {
            font-size: 32px;
            color: white;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: 800;
            margin: 0 0 5px 0;
            letter-spacing: 1px;
        }
        
        .header p {
            font-size: 12px;
            opacity: 0.85;
            margin: 0;
        }
        
        /* ========================================== */
        /* TITRE DU REÇU */
        /* ========================================== */
        .receipt-title {
            text-align: center;
            padding: 20px;
            border-bottom: 2px solid #e2e8f0;
        }
        
        .receipt-title h2 {
            font-size: 18px;
            font-weight: 700;
            color: #ea580c;
            margin: 0;
            letter-spacing: 2px;
        }
        
        .receipt-number {
            font-size: 12px;
            color: #64748b;
            margin-top: 5px;
            font-family: monospace;
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
            padding: 12px 15px;
            border-left: 3px solid #ea580c;
        }
        
        .info-label {
            display: block;
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        
        .info-value {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }
        
        /* Séparateur */
        .separator {
            height: 1px;
            background: #e2e8f0;
            margin: 20px 0;
        }
        
        /* Détails du paiement */
        .details-table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        
        .details-table td {
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .details-table .label {
            color: #64748b;
            font-size: 13px;
        }
        
        .details-table .value {
            font-weight: 600;
            font-size: 13px;
            color: #1e293b;
            text-align: right;
        }
        
        /* Total */
        .total-box {
            background: #fff7ed;
            padding: 15px 20px;
            margin: 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #fed7aa;
        }
        
        .total-label {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
        }
        
        .total-value {
            font-size: 22px;
            font-weight: 800;
            color: #ea580c;
        }
        
        /* Statut */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 15px;
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
        
        /* Signature */
        .signature {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
        }
        
        .signature-line {
            width: 200px;
            height: 1px;
            background: #cbd5e1;
            margin: 0 auto 10px;
        }
        
        .signature p {
            font-size: 10px;
            color: #94a3b8;
            margin: 0;
        }
        
        /* ========================================== */
        /* FOOTER */
        /* ========================================== */
        .footer {
            background: #f8fafc;
            padding: 15px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer p {
            font-size: 10px;
            color: #94a3b8;
            margin: 3px 0;
        }
        
        /* ========================================== */
        /* IMPRESSION */
        /* ========================================== */
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .receipt-container {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- En-tête -->
        <div class="header">
            <div class="logo">
                <i class="fas fa-school"></i>
            </div>
            <h1>Collège Notre-Dame de Grâce</h1>
            <p>Lubumbashi, République Démocratique du Congo</p>
            <p style="font-size: 10px; margin-top: 5px;">Tél: +243 123 456 789 | Email: info@college-ndg.cd</p>
        </div>
        
        <!-- Titre -->
        <div class="receipt-title">
            <h2>REÇU DE PAIEMENT</h2>
            <div class="receipt-number">N° {{ $paiement->reference }}</div>
        </div>
        
        <!-- Corps -->
        <div class="content">
            <!-- Grille d'informations -->
            <div class="info-grid">
                <div class="info-box">
                    <span class="info-label">Date du paiement</span>
                    <span class="info-value">{{ $paiement->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                <div class="info-box">
                    <span class="info-label">Code transaction</span>
                    <span class="info-value">{{ $paiement->code_transaction ?? 'N/A' }}</span>
                </div>
                <div class="info-box">
                    <span class="info-label">Élève</span>
                    <span class="info-value">{{ $paiement->eleve->prenom ?? '' }} {{ $paiement->eleve->nom ?? '' }}</span>
                </div>
                <div class="info-box">
                    <span class="info-label">Classe</span>
                    <span class="info-value">{{ $paiement->eleve->classe->nom_classe ?? 'N/A' }}</span>
                </div>
            </div>
            
            <!-- Détails du paiement -->
            <table class="details-table">
                <tr>
                    <td class="label">Frais</td>
                    <td class="value">{{ $paiement->frais->libelle ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Opérateur</td>
                    <td class="value">{{ ucfirst($paiement->operateur) }} Money</td>
                </tr>
                <tr>
                    <td class="label">Numéro de téléphone</td>
                    <td class="value">{{ $paiement->numero_mobile ?? 'N/A' }}</td>
                </tr>
            </table>
            
            <div class="separator"></div>
            
            <!-- Total -->
            <div class="total-box">
                <span class="total-label">TOTAL PAYÉ</span>
                <span class="total-value">{{ number_format($paiement->montant, 0, ',', ' ') }} {{ $paiement->devise ?? 'FC' }}</span>
            </div>
            
            <!-- Statut -->
            <div style="text-align: center; margin: 20px 0;">
                <span class="status-badge status-{{ $paiement->statut }}">
                    <i class="fas {{ $paiement->statut == 'valide' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                    {{ $paiement->statut == 'valide' ? 'Paiement validé' : 'En attente de validation' }}
                </span>
            </div>
            
            <!-- Signature -->
            <div class="signature">
                <div class="signature-line"></div>
                <p>Signature du Collège Notre-Dame de Grâce</p>
                <p style="margin-top: 5px;">Cachet de l'établissement</p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>Ce reçu fait foi de paiement. Merci de votre confiance.</p>
            <p>Document généré automatiquement le {{ now()->format('d/m/Y à H:i') }}</p>
        </div>
    </div>
</body>
</html>