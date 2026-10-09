{{-- resources/views/parent/paiement/form.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Paiement des frais scolaires</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; padding: 20px; }
        .container-fluid { max-width: 1400px; margin: 0 auto; }
        .row { display: flex; flex-wrap: wrap; margin: 0 -10px; }
        .col-lg-5, .col-lg-7 { padding: 0 10px; }
        .col-lg-5 { width: 41.666%; }
        .col-lg-7 { width: 58.333%; }
        .selection-card, .payment-card { background: #ffffff; box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow: hidden; border-radius: 8px; margin-bottom: 20px; }
        .card-header-custom { background: linear-gradient(135deg, #0F2B3D 0%, #1A4058 100%); padding: 15px 20px; display: flex; align-items: center; gap: 10px; color: white; }
        .card-header-custom i { font-size: 20px; }
        .card-header-custom h3 { font-size: 16px; font-weight: 600; margin: 0; }
        .card-body-custom { padding: 20px; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #1e293b; }
        .form-label.required::after { content: '*'; color: #ef4444; margin-left: 4px; }
        .form-control { width: 100%; padding: 12px 15px; border: 1px solid #e2e8f0; font-size: 14px; transition: all 0.3s; border-radius: 6px; background: white; }
        .form-control:focus { outline: none; border-color: #1A4058; box-shadow: 0 0 0 2px rgba(26,64,88,0.1); }
        .input-group { display: flex; align-items: center; }
        .input-prefix { background: #f1f5f9; padding: 12px 15px; border: 1px solid #e2e8f0; border-right: none; font-size: 14px; border-radius: 6px 0 0 6px; }
        .input-group .form-control { border-left: none; border-radius: 0 6px 6px 0; }
        .form-hint { display: block; font-size: 11px; color: #64748b; margin-top: 5px; }
        .operator-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .operator-card { cursor: pointer; }
        .operator-card input { display: none; }
        .operator-card input:checked + .operator-content { border-color: #D4AF37; background: #f3e8ff; }
        .operator-content { display: flex; flex-direction: column; align-items: center; gap: 8px; padding: 15px; border: 2px solid #e2e8f0; transition: all 0.3s; cursor: pointer; border-radius: 8px; }
        .operator-content i { font-size: 28px; }
        .operator-content span { font-size: 12px; font-weight: 500; }
        .frais-item { padding: 15px; border: 1px solid #e2e8f0; margin-bottom: 12px; cursor: pointer; transition: all 0.3s; display: flex; justify-content: space-between; align-items: center; border-radius: 8px; }
        .frais-item:hover { border-color: #D4AF37; background: #f8fafc; }
        .frais-item.selected { border-color: #D4AF37; background: #f3e8ff; }
        .frais-info { flex: 1; }
        .frais-libelle { font-weight: 600; color: #1e293b; margin-bottom: 5px; }
        .frais-desc { font-size: 11px; color: #64748b; }
        .frais-montant { text-align: right; }
        .montant-value { font-weight: 700; font-size: 16px; color: #1e293b; }
        .penalite-badge { font-size: 10px; background: #fee2e2; color: #dc2626; padding: 2px 6px; margin-left: 8px; border-radius: 4px; }
        .selected-info { background: #f3e8ff; padding: 15px; border-left: 3px solid #D4AF37; border-radius: 6px; }
        .selected-info p { margin: 5px 0; font-size: 13px; }
        .selected-info strong { color: #1A4058; }
        .payment-summary { background: #f8fafc; padding: 15px; margin: 20px 0; border: 1px solid #e2e8f0; border-radius: 6px; }
        .summary-row { display: flex; justify-content: space-between; padding: 8px 0; }
        .summary-total { border-top: 1px solid #e2e8f0; margin-top: 8px; padding-top: 8px; }
        .summary-total .summary-value { font-size: 18px; color: #D4AF37; font-weight: 700; }
        .form-actions { margin-top: 20px; }
        .btn-payer { width: 100%; background: #0F2B3D; border: none; padding: 14px; color: white; font-weight: 600; font-size: 16px; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px; border-radius: 8px; }
        .btn-payer:hover { background: #1A4058; transform: translateY(-2px); }
        .btn-payer:disabled { opacity: 0.7; cursor: not-allowed; }
        .error-message { color: #ef4444; font-size: 12px; margin-top: 5px; }
        .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; }
        .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-info { background: #e0f2fe; color: #075985; border: 1px solid #bae6fd; }
        @media (max-width: 992px) { .col-lg-5, .col-lg-7 { width: 100%; } .operator-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success mb-4">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-4">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-5">
                <div class="selection-card">
                    <div class="card-header-custom">
                        <i class="fas fa-child"></i>
                        <h3>1. Sélectionnez votre enfant</h3>
                    </div>
                    <div class="card-body-custom">
                        <div class="form-group">
                            <label class="form-label required">Classe</label>
                            <select id="classeSelect" class="form-control" onchange="loadEnfants()">
                                <option value="">Sélectionnez une classe</option>
                                @foreach($classes as $classe)
                                    <option value="{{ $classe->id_classe }}">
                                        {{ $classe->nom_classe }} - {{ $classe->niveau }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label required">Élève</label>
                            <select id="eleveSelect" class="form-control" onchange="loadFrais()">
                                <option value="">Sélectionnez d'abord une classe</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="selection-card mt-4" id="fraisCard" style="display: none;">
                    <div class="card-header-custom">
                        <i class="fas fa-money-bill-wave"></i>
                        <h3>2. Sélectionnez le frais à payer</h3>
                    </div>
                    <div class="card-body-custom">
                        <div id="fraisList"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="payment-card" id="paymentCard" style="display: none;">
                    <div class="card-header-custom">
                        <i class="fas fa-credit-card"></i>
                        <h3>3. Informations de paiement</h3>
                    </div>
                    <div class="card-body-custom">
                        <div id="selectedInfo" class="selected-info mb-4"></div>

                        <form id="paymentForm" method="POST" action="{{ route('parent.paiement.process') }}">
                            @csrf
                            <input type="hidden" name="eleve_id" id="eleveId">
                            <input type="hidden" name="frais_id" id="fraisId">
                            <input type="hidden" name="montant" id="montantHidden">
                            <input type="hidden" name="devise" id="deviseHidden" value="FC">

                            <div class="form-group">
                                <label class="form-label required">Opérateur Mobile Money</label>
                                <div class="operator-grid">
                                    @foreach($operateurs as $operateur)
                                        <label class="operator-card">
                                            <input type="radio" name="operateur" value="{{ $operateur->operateur }}" required>
                                            <div class="operator-content">
                                                <i class="fas fa-mobile-alt"></i>
                                                <span>{{ ucfirst($operateur->operateur) }} Money</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                <div id="operateurError" class="error-message" style="display:none;">Veuillez sélectionner un opérateur</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Numéro Mobile Money</label>
                                <div class="input-group">
                                    <span class="input-prefix">+243</span>
                                    <input type="tel" name="numero_mobile" id="numeroMobile" class="form-control" placeholder="812345678" value="{{ old('numero_mobile') }}" required>
                                </div>
                                <div id="mobileError" class="error-message" style="display:none;">Veuillez entrer un numéro valide (9 chiffres)</div>
                                <small class="form-hint">Exemple : 812345678 ou 991234567</small>
                            </div>

                            <div id="paymentSummary" class="payment-summary">
                                <div class="summary-row summary-total">
                                    <span class="summary-label">TOTAL À PAYER</span>
                                    <span class="summary-value" id="montantAffichage" style="font-size:20px; color:#D4AF37; font-weight:700;">0 FC</span>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="button" class="btn-payer" id="submitBtn" onclick="validateAndSubmit()">
                                    <i class="fas fa-check-circle"></i> Confirmer le paiement
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Données réelles du controller
        const enfantsData = @json($enfantsData);
        const fraisData = @json($fraisData);

        console.log('enfantsData:', enfantsData);
        console.log('fraisData:', fraisData);

        /**
         * Formate un montant avec sa devise
         * @param {number} montant - Le montant à formater
         * @param {string} devise - La devise (USD ou FC)
         * @returns {string} Le montant formaté
         */
        function formatMontant(montant, devise) {
            if (devise === 'USD') {
                return montant.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' USD';
            } else {
                return montant.toLocaleString('fr-FR', { minimumFractionDigits: 0, maximumFractionDigits: 0 }) + ' FC';
            }
        }

        function loadEnfants() {
            const classeId = document.getElementById('classeSelect').value;
            const eleveSelect = document.getElementById('eleveSelect');
            const fraisCard = document.getElementById('fraisCard');
            const paymentCard = document.getElementById('paymentCard');

            eleveSelect.innerHTML = '<option value="">Sélectionnez un élève</option>';
            fraisCard.style.display = 'none';
            paymentCard.style.display = 'none';

            if (classeId && enfantsData[classeId]) {
                enfantsData[classeId].forEach(enfant => {
                    const option = document.createElement('option');
                    option.value = enfant.id;
                    option.textContent = enfant.nom;
                    eleveSelect.appendChild(option);
                });
            }
        }

        function loadFrais() {
            const eleveId = document.getElementById('eleveSelect').value;
            const fraisCard = document.getElementById('fraisCard');
            const fraisList = document.getElementById('fraisList');
            const paymentCard = document.getElementById('paymentCard');

            fraisList.innerHTML = '';
            paymentCard.style.display = 'none';

            console.log('Élève ID sélectionné:', eleveId);
            console.log('FraisData pour cet élève:', fraisData[eleveId]);

            if (eleveId && fraisData[eleveId] && fraisData[eleveId].length > 0) {
                fraisData[eleveId].forEach(frais => {
                    const div = document.createElement('div');
                    div.className = 'frais-item';
                    
                    const libelle = frais.libelle || 'Frais scolaire';
                    const montantFinal = frais.montant_final || frais.montant;
                    const devise = frais.devise || 'FC';
                    const estDepasse = frais.est_depasse || false;

                    div.onclick = function() {
                        document.querySelectorAll('.frais-item').forEach(item => item.classList.remove('selected'));
                        div.classList.add('selected');
                        
                        document.getElementById('eleveId').value = eleveId;
                        document.getElementById('fraisId').value = frais.id_frais;
                        document.getElementById('montantHidden').value = montantFinal;
                        document.getElementById('deviseHidden').value = devise;
                        
                        const eleveNom = document.getElementById('eleveSelect').options[document.getElementById('eleveSelect').selectedIndex]?.text || '';
                        const montantFormate = formatMontant(montantFinal, devise);
                        
                        document.getElementById('selectedInfo').innerHTML = `
                            <p><strong>👨‍🎓 Élève :</strong> ${eleveNom}</p>
                            <p><strong>📄 Frais :</strong> ${libelle}</p>
                            <p><strong>💰 Montant à payer :</strong> <strong style="color:#D4AF37; font-size:18px;">${montantFormate}</strong></p>
                        `;
                        
                        document.getElementById('paymentSummary').innerHTML = `
                            <div class="summary-row summary-total">
                                <span class="summary-label">TOTAL À PAYER</span>
                                <span class="summary-value" style="font-size:20px; color:#D4AF37; font-weight:700;">
                                    ${montantFormate}
                                </span>
                            </div>
                        `;
                        
                        document.getElementById('paymentCard').style.display = 'block';
                    };

                    const montantFormate = formatMontant(montantFinal, devise);

                    div.innerHTML = `
                        <div class="frais-info">
                            <div class="frais-libelle">${libelle}</div>
                            <div class="frais-desc">${frais.description || ''}</div>
                        </div>
                        <div class="frais-montant">
                            <div class="montant-value">
                                ${montantFormate}
                            </div>
                            ${estDepasse ? '<div class="penalite-badge">⚠️ + pénalité</div>' : ''}
                        </div>
                    `;

                    fraisList.appendChild(div);
                });
                
                fraisCard.style.display = 'block';
            } else {
                fraisCard.style.display = 'none';
                fraisList.innerHTML = '<div class="alert alert-info">Aucun frais disponible pour cet élève.</div>';
            }
        }

        function validateAndSubmit() {
            const operateur = document.querySelector('input[name="operateur"]:checked');
            const operateurError = document.getElementById('operateurError');
            const mobileError = document.getElementById('mobileError');
            const numeroMobile = document.getElementById('numeroMobile').value;
            const cleanNumber = numeroMobile.replace(/[\s\-\(\)\+]/g, '');
            const montantHidden = document.getElementById('montantHidden').value;
            const fraisId = document.getElementById('fraisId').value;
            const eleveId = document.getElementById('eleveId').value;
            const devise = document.getElementById('deviseHidden').value;

            if (!fraisId || !eleveId || !montantHidden) {
                alert('Veuillez d\'abord sélectionner un frais à payer.');
                return;
            }

            if (!operateur) {
                operateurError.style.display = 'block';
                return;
            } else {
                operateurError.style.display = 'none';
            }

            if (!cleanNumber || cleanNumber.length !== 9) {
                mobileError.style.display = 'block';
                return;
            } else {
                mobileError.style.display = 'none';
            }

            document.getElementById('numeroMobile').value = cleanNumber;

            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement en cours...';
            submitBtn.disabled = true;
            document.getElementById('paymentForm').submit();
        }

        document.getElementById('numeroMobile').addEventListener('input', function(e) {
            let value = this.value.replace(/[^0-9]/g, '');
            if (value.length > 9) value = value.slice(0, 9);
            this.value = value;
        });
    </script>
</body>
</html>