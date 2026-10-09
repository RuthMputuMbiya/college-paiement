{{-- resources/views/parent/paiement/form.blade.php --}}
@extends('layouts.parent')

@section('title', 'Effectuer un paiement')
@section('page-title', 'Paiement des frais scolaires')
@section('page-subtitle', 'Payez les frais de scolarité de vos enfants en toute simplicité')

@section('content')
<div class="container-fluid px-0" data-aos="fade-up">

    <div class="row g-4">
        <!-- Colonne gauche - Sélection -->
        <div class="col-lg-5">
            <div class="selection-card">
                <div class="card-header-custom">
                    <i class="fas fa-child"></i>
                    <h3>1. Sélectionnez votre enfant</h3>
                </div>
                <div class="card-body-custom">
                    <div class="form-group">
                        <label class="form-label required">
                            <i class="fas fa-building"></i> Classe
                        </label>
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
                        <label class="form-label required">
                            <i class="fas fa-user-graduate"></i> Élève
                        </label>
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

        <!-- Colonne droite - Formulaire de paiement -->
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

                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-mobile-alt"></i> Opérateur Mobile Money
                            </label>
                            <div class="operator-grid">
                                @foreach($operateurs as $operateur)
                                <label class="operator-card">
                                    <input type="radio" name="operateur" value="{{ $operateur->operateur }}" required>
                                    <div class="operator-content">
                                        <i class="fas {{ $operateur->operateur == 'airtel' ? 'fa-signal' : ($operateur->operateur == 'orange' ? 'fa-circle' : 'fa-charging-station') }}"></i>
                                        <span>{{ ucfirst($operateur->operateur) }} Money</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            <div id="operateurError" class="error-message" style="display: none; color: #ef4444; font-size: 12px; margin-top: 5px;">
                                Veuillez sélectionner un opérateur
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-phone"></i> Numéro Mobile Money
                            </label>
                            <div class="input-group">
                                <span class="input-prefix">+243</span>
                                <input type="tel" name="numero_mobile" id="numeroMobile" class="form-control" 
                                       placeholder="XXX XXX XXX" required>
                            </div>
                            <div id="mobileError" class="error-message" style="display: none; color: #ef4444; font-size: 12px; margin-top: 5px;">
                                Veuillez entrer un numéro de téléphone valide
                            </div>
                            <small class="form-hint">Entrez le numéro associé à votre compte Mobile Money</small>
                        </div>

                        <div id="paymentSummary" class="payment-summary"></div>

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

@push('styles')
<style>
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -10px;
    }
    .col-lg-5, .col-lg-7 {
        padding: 0 10px;
    }
    .col-lg-5 { width: 41.666%; }
    .col-lg-7 { width: 58.333%; }

    .selection-card, .payment-card {
        background: white;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .card-header-custom {
        background: linear-gradient(135deg, #6b21a5 0%, #7e22ce 100%);
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: white;
    }
    .card-header-custom i { font-size: 20px; }
    .card-header-custom h3 { font-size: 16px; font-weight: 600; margin: 0; }
    .card-body-custom { padding: 20px; }

    .form-group { margin-bottom: 20px; }
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 13px;
        color: #1e293b;
    }
    .form-label.required::after { content: '*'; color: #ef4444; margin-left: 4px; }
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        font-size: 14px;
        transition: all 0.3s;
    }
    .form-control:focus {
        outline: none;
        border-color: #7e22ce;
        box-shadow: 0 0 0 2px rgba(126,34,206,0.1);
    }
    .input-group { display: flex; align-items: center; }
    .input-prefix {
        background: #f1f5f9;
        padding: 12px 15px;
        border: 1px solid #e2e8f0;
        border-right: none;
        font-size: 14px;
    }
    .input-group .form-control { border-left: none; }
    .form-hint {
        display: block;
        font-size: 11px;
        color: #64748b;
        margin-top: 5px;
    }

    .operator-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }
    .operator-card { cursor: pointer; }
    .operator-card input { display: none; }
    .operator-card input:checked + .operator-content {
        border-color: #7e22ce;
        background: #f3e8ff;
    }
    .operator-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        padding: 15px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s;
        cursor: pointer;
    }
    .operator-content i { font-size: 28px; }
    .operator-content span { font-size: 12px; font-weight: 500; }

    .frais-item {
        padding: 15px;
        border: 1px solid #e2e8f0;
        margin-bottom: 12px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .frais-item:hover {
        border-color: #7e22ce;
        background: #f8fafc;
    }
    .frais-item.selected {
        border-color: #7e22ce;
        background: #f3e8ff;
    }
    .frais-info { flex: 1; }
    .frais-libelle { font-weight: 600; color: #1e293b; margin-bottom: 5px; }
    .frais-desc { font-size: 11px; color: #64748b; }
    .frais-montant { text-align: right; }
    .montant-value { font-weight: 700; font-size: 16px; color: #1e293b; }
    .penalite-badge {
        font-size: 10px;
        background: #fee2e2;
        color: #dc2626;
        padding: 2px 6px;
        margin-left: 8px;
    }

    .selected-info {
        background: #f3e8ff;
        padding: 15px;
        border-left: 3px solid #7e22ce;
    }
    .selected-info p { margin: 5px 0; font-size: 13px; }
    .selected-info strong { color: #7e22ce; }

    .payment-summary {
        background: #f8fafc;
        padding: 15px;
        margin: 20px 0;
        border: 1px solid #e2e8f0;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
    }
    .summary-total {
        border-top: 1px solid #e2e8f0;
        margin-top: 8px;
        padding-top: 8px;
    }
    .summary-total .summary-value {
        font-size: 18px;
        color: #7e22ce;
        font-weight: 700;
    }

    .form-actions { margin-top: 20px; }
    .btn-payer {
        width: 100%;
        background: #7e22ce;
        border: none;
        padding: 14px;
        color: white;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .btn-payer:hover {
        background: #6b21a5;
        transform: translateY(-2px);
    }

    .error-message {
        font-size: 12px;
        margin-top: 5px;
    }

    @media (max-width: 992px) {
        .col-lg-5, .col-lg-7 { width: 100%; }
        .operator-grid { grid-template-columns: 1fr; }
    }
</style>
@endpush

@push('scripts')
<script>
    // Données des enfants par classe
    const enfantsData = @json($enfantsData);
    const fraisData = @json($fraisData);

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
        
        if (eleveId && fraisData[eleveId]) {
            fraisList.innerHTML = '';
            fraisData[eleveId].forEach(frais => {
                const div = document.createElement('div');
                div.className = 'frais-item';
                div.onclick = () => selectFrais(frais.id, frais.libelle, frais.montant, frais.devise, frais.penalite, frais.est_depasse, frais.montant_final);
                div.innerHTML = `
                    <div class="frais-info">
                        <div class="frais-libelle">${frais.libelle}</div>
                        <div class="frais-desc">${frais.description || ''}</div>
                    </div>
                    <div class="frais-montant">
                        <div class="montant-value">${new Intl.NumberFormat('fr-FR').format(frais.montant_final)} ${frais.devise}</div>
                        ${frais.est_depasse ? `<div class="penalite-badge">+ pénalité</div>` : ''}
                    </div>
                `;
                fraisList.appendChild(div);
            });
            fraisCard.style.display = 'block';
            paymentCard.style.display = 'none';
        } else {
            fraisCard.style.display = 'none';
        }
    }

    function selectFrais(fraisId, libelle, montant, devise, penalite, estDepasse, montantFinal) {
        const eleveSelect = document.getElementById('eleveSelect');
        const eleveId = eleveSelect.value;
        const eleveNom = eleveSelect.options[eleveSelect.selectedIndex]?.text;
        
        document.getElementById('eleveId').value = eleveId;
        document.getElementById('fraisId').value = fraisId;
        document.getElementById('montantHidden').value = montantFinal;
        
        document.getElementById('selectedInfo').innerHTML = `
            <p><strong>📚 Élève :</strong> ${eleveNom}</p>
            <p><strong>💰 Frais :</strong> ${libelle}</p>
            <p><strong>💵 Montant :</strong> ${new Intl.NumberFormat('fr-FR').format(montant)} ${devise}</p>
            ${estDepasse ? `<p><strong>⚠️ Pénalité :</strong> +${new Intl.NumberFormat('fr-FR').format(penalite)} ${devise}</p>` : ''}
            <p><strong>🔹 Total à payer :</strong> ${new Intl.NumberFormat('fr-FR').format(montantFinal)} ${devise}</p>
        `;
        
        document.getElementById('paymentSummary').innerHTML = `
            <div class="summary-row">
                <span class="summary-label">Montant ${libelle}</span>
                <span class="summary-value">${new Intl.NumberFormat('fr-FR').format(montantFinal)} ${devise}</span>
            </div>
            <div class="summary-row summary-total">
                <span class="summary-label">Total à payer</span>
                <span class="summary-value">${new Intl.NumberFormat('fr-FR').format(montantFinal)} ${devise}</span>
            </div>
        `;
        
        document.querySelectorAll('.frais-item').forEach(item => item.classList.remove('selected'));
        event.currentTarget.classList.add('selected');
        document.getElementById('paymentCard').style.display = 'block';
    }

    function validateAndSubmit() {
        // Vérifier si un opérateur est sélectionné
        const operateur = document.querySelector('input[name="operateur"]:checked');
        const operateurError = document.getElementById('operateurError');
        
        if (!operateur) {
            operateurError.style.display = 'block';
            operateurError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        } else {
            operateurError.style.display = 'none';
        }
        
        // Vérifier le numéro de mobile
        const numeroMobile = document.getElementById('numeroMobile').value;
        const mobileError = document.getElementById('mobileError');
        
        if (!numeroMobile || numeroMobile.length < 9) {
            mobileError.style.display = 'block';
            mobileError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        } else {
            mobileError.style.display = 'none';
        }
        
        // Afficher un loader
        const submitBtn = document.getElementById('submitBtn');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement en cours...';
        submitBtn.disabled = true;
        
        // Soumettre le formulaire
        document.getElementById('paymentForm').submit();
    }
</script>
@endpush
@endsection