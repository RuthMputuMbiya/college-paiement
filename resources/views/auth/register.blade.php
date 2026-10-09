{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription Parent - Collège Notre-Dame de Grâce</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        /* ============================================
           DESIGN BLEU CIEL PROFESSIONNEL
           Blanc, gris, bleu ciel, footer noir
        ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Couleurs - bleu ciel élégant */
            --primary: #064e6f;
            --primary-dark: #3a0048;
            --primary-light: #06709e;
            --primary-soft: #e0f2fe;
            --secondary: #1e293b;
            --secondary-dark: #0f172a;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --white: #ffffff;
            
            /* Dégradés */
            --gradient-primary: linear-gradient(135deg, #076c97 0%, #31548b 100%);
            --gradient-bg: linear-gradient(135deg, #045d87 0%, #e9efef 50%, #0284c7 100%);
            
            /* Ombres */
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
            
            --transition: all 0.2s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gradient-bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Animation d'arrière-plan */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><circle cx="20" cy="20" r="15" fill="%23ffffff" opacity="0.05"/><circle cx="80" cy="80" r="25" fill="%23ffffff" opacity="0.05"/><circle cx="90" cy="30" r="10" fill="%23ffffff" opacity="0.05"/></svg>');
            background-size: cover;
            pointer-events: none;
        }

        /* Coins arrondis modernes */
        .auth-card, .btn, input, select, textarea, .alert, .info-banner, .auth-logo, .strength-bar {
            border-radius: 14px !important;
        }

        /* ============================================
           CARTE PRINCIPALE
        ============================================ */
        .auth-container {
            width: 100%;
            max-width: 600px;
            position: relative;
            z-index: 10;
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-card {
            background: var(--white);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
        }

        /* Header avec dégradé bleu ciel */
        .auth-header {
            background: var(--gradient-primary);
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .auth-logo {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            position: relative;
            z-index: 1;
        }

        .auth-logo i {
            font-size: 2.5rem;
            color: var(--white);
        }

        .auth-header h1 {
            color: var(--white);
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            position: relative;
            z-index: 1;
        }

        .auth-header p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.875rem;
            position: relative;
            z-index: 1;
        }

        /* Info Banner */
        .info-banner {
            background: var(--primary-soft);
            padding: 1rem;
            margin: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .info-banner i {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .info-banner p {
            font-size: 0.8rem;
            color: var(--gray-700);
        }

        /* Body */
        .auth-body {
            padding: 2rem;
        }

        /* Formulaires */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--gray-700);
        }

        .form-label i {
            margin-right: 0.5rem;
            color: var(--primary);
        }

        .form-label .required {
            color: var(--danger);
            margin-left: 0.25rem;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: var(--gray-400);
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .form-control:focus + .input-icon {
            color: var(--primary);
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.5rem;
            border: 1px solid var(--gray-200);
            font-size: 0.875rem;
            transition: var(--transition);
            background: var(--white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }

        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            color: var(--gray-400);
            cursor: pointer;
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Password Strength */
        .password-strength {
            margin-top: 0.5rem;
        }

        .strength-bar {
            height: 4px;
            background: var(--gray-200);
            margin-bottom: 0.5rem;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: var(--transition);
        }

        .strength-text {
            font-size: 0.7rem;
            color: var(--gray-500);
        }

        /* Checkbox */
        .checkbox-group {
            margin-bottom: 1.5rem;
        }

        .checkbox-label {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            cursor: pointer;
        }

        .checkbox-label input {
            margin-top: 0.2rem;
            accent-color: var(--primary);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .checkbox-text {
            font-size: 0.75rem;
            color: var(--gray-500);
            line-height: 1.4;
        }

        .checkbox-text a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .checkbox-text a:hover {
            text-decoration: underline;
            color: var(--primary-dark);
        }

        /* Bouton Inscription */
        .btn-register {
            width: 100%;
            padding: 0.875rem;
            background: var(--primary);
            border: none;
            color: var(--white);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-register:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Alertes */
        .alert {
            padding: 0.875rem 1rem;
            margin: 1rem 1rem 0 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
        }

        /* Error message */
        .text-danger {
            color: var(--danger);
            font-size: 0.7rem;
            margin-top: 0.25rem;
            display: block;
        }

        /* Footer - NOIR */
        .auth-footer {
            background: var(--gray-900);
            padding: 1.25rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--gray-400);
        }

        .auth-footer a {
            color: var(--primary-light);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .auth-footer a:hover {
            color: var(--white);
            text-decoration: underline;
        }

        .auth-footer p {
            margin: 0;
        }

        .auth-footer .mt-2 {
            margin-top: 0.5rem;
        }

        /* Bouton Retour Accueil */
        .back-home-btn {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            color: var(--white);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
            z-index: 100;
            cursor: pointer;
            border-radius: 50px !important;
        }

        .back-home-btn i {
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .back-home-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateX(-5px);
            color: var(--white);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .back-home-btn:hover i {
            transform: translateX(-3px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .auth-body {
                padding: 1.5rem;
            }
            
            .back-home-btn {
                bottom: 1rem;
                left: 1rem;
                padding: 0.5rem 1rem;
                font-size: 0.75rem;
            }
            
            .auth-logo {
                width: 60px;
                height: 60px;
            }
            
            .auth-logo i {
                font-size: 1.75rem;
            }
            
            .auth-header h1 {
                font-size: 1.25rem;
            }
            
            .info-banner {
                margin: 0.75rem;
                padding: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .auth-body {
                padding: 1rem;
            }
            
            .checkbox-label {
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <!-- Bouton Retour Accueil -->
    <a href="{{ url('/') }}" class="back-home-btn">
        <i class="fas fa-arrow-left"></i>
        <span>Retour à l'accueil</span>
    </a>

    <div class="auth-container">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1>Inscription Parent</h1>
                <p>Créez votre compte pour suivre la scolarité de vos enfants</p>
            </div>

            <!-- Info Banner -->
            <div class="info-banner">
                <i class="fas fa-info-circle"></i>
                <p>Créez un compte pour payer les frais scolaires en ligne, suivre vos paiements et recevoir les reçus.</p>
            </div>

            <!-- Session Status -->
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> Veuillez corriger les erreurs ci-dessous.
                </div>
            @endif

            <!-- Register Form -->
            <div class="auth-body">
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-user"></i> Nom complet <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <i class="fas fa-user input-icon"></i>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                            </div>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-phone"></i> Téléphone <span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <i class="fas fa-phone input-icon"></i>
                                <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}" required>
                            </div>
                            @error('telephone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-envelope"></i> Email <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt"></i> Adresse
                            </label>
                            <div class="input-group">
                                <i class="fas fa-map-marker-alt input-icon"></i>
                                <input type="text" name="adresse" class="form-control" value="{{ old('adresse') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-briefcase"></i> Profession
                            </label>
                            <div class="input-group">
                                <i class="fas fa-briefcase input-icon"></i>
                                <input type="text" name="profession" class="form-control" value="{{ old('profession') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock"></i> Mot de passe <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <i class="fas fa-key input-icon"></i>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                            <div class="strength-text" id="strengthText">Entrez un mot de passe sécurisé</div>
                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-check-circle"></i> Confirmer le mot de passe <span class="required">*</span>
                        </label>
                        <div class="input-group">
                            <i class="fas fa-check-circle input-icon"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                   

                    <button type="submit" class="btn-register">
                        <i class="fas fa-user-plus"></i> Créer mon compte
                    </button>
                </form>
            </div>

            <!-- Footer - NOIR -->
            <div class="auth-footer">
                <p>Vous avez déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a></p>
                <p class="mt-2">© {{ date('Y') }} Collège Notre-Dame de Grâce - Tous droits réservés</p>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 600, once: true });

        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.parentElement.querySelector('.password-toggle i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password strength checker
        const password = document.getElementById('password');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');

        if (password) {
            password.addEventListener('input', function() {
                const val = this.value;
                let strength = 0;
                
                if (val.length === 0) {
                    strengthFill.style.width = '0%';
                    strengthText.innerHTML = 'Entrez un mot de passe sécurisé';
                    strengthText.style.color = '#6b7280';
                    strengthFill.style.backgroundColor = '';
                    return;
                }
                
                if (val.length >= 8) strength++;
                if (val.match(/[a-z]/)) strength++;
                if (val.match(/[A-Z]/)) strength++;
                if (val.match(/[0-9]/)) strength++;
                if (val.match(/[^a-zA-Z0-9]/)) strength++;
                
                if (strength <= 2) {
                    strengthFill.style.backgroundColor = '#ef4444';
                    strengthText.style.color = '#ef4444';
                    strengthText.innerHTML = 'Mot de passe : Faible';
                } else if (strength <= 4) {
                    strengthFill.style.backgroundColor = '#f59e0b';
                    strengthText.style.color = '#f59e0b';
                    strengthText.innerHTML = 'Mot de passe : Moyen';
                } else {
                    strengthFill.style.backgroundColor = '#10b981';
                    strengthText.style.color = '#10b981';
                    strengthText.innerHTML = 'Mot de passe : Fort';
                }
                
                strengthFill.style.width = (strength / 5 * 100) + '%';
            });
        }

        // Validation des conditions
        const registerForm = document.getElementById('registerForm');
        if (registerForm) {
            registerForm.addEventListener('submit', function(e) {
                const terms = document.getElementById('terms');
                if (!terms.checked) {
                    e.preventDefault();
                    alert('Veuillez accepter les conditions générales.');
                }
            });
        }
    </script>
</body>
</html>