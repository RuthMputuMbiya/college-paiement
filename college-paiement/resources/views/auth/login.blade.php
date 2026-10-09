{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - Collège Notre-Dame de Grâce</title>
    
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
           VARIABLES - DESIGN MODERNE
           COINS CARRÉS - PROFESSIONNEL
        ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Couleurs principales - Dégradé moderne violet/bleu */
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --secondary: #06b6d4;
            --secondary-dark: #0891b2;
            --accent: #f43f5e;
            --accent-light: #fb7185;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            --dark-light: #334155;
            --gray: #64748b;
            --gray-light: #f8fafc;
            --white: #ffffff;
            
            /* Dégradés */
            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #06b6d4 100%);
            --gradient-bg: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
            --gradient-card: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            
            /* Ombres */
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --shadow-glow: 0 0 20px rgba(99, 102, 241, 0.4);
            
            --transition: all 0.3s ease;
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><circle cx="20" cy="20" r="15" fill="%236366f1" opacity="0.05"/><circle cx="80" cy="80" r="25" fill="%238b5cf6" opacity="0.05"/><circle cx="90" cy="30" r="10" fill="%2306b6d4" opacity="0.05"/></svg>');
            background-size: cover;
            pointer-events: none;
        }

        /* Coins carrés */
        .auth-card, .btn, input, select, textarea, .alert, .role-card, .role-icon, .auth-logo {
            border-radius: 0px !important;
        }

        /* ============================================
           CARTE PRINCIPALE MODERNE
        ============================================ */
        .auth-container {
            width: 100%;
            max-width: 500px;
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
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        /* Header avec dégradé */
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
            border: 1px solid rgba(255, 255, 255, 0.3);
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

        /* Role Selector Modernisé */
        .role-selector {
            padding: 1.5rem;
            background: var(--gray-light);
            border-bottom: 1px solid #e2e8f0;
        }

        .role-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .role-title i {
            color: var(--primary);
        }

        .role-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.75rem;
        }

        .role-card {
            background: var(--white);
            padding: 0.75rem 0.5rem;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            border: 2px solid #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: var(--transition);
        }

        .role-card:hover::before {
            transform: scaleX(1);
        }

        .role-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            border-color: var(--primary-light);
        }

        .role-card.selected {
            border-color: var(--primary);
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
        }

        .role-card.selected::before {
            transform: scaleX(1);
        }

        .role-icon {
            width: 45px;
            height: 45px;
            background: rgba(99, 102, 241, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.5rem;
            transition: var(--transition);
        }

        .role-card.selected .role-icon {
            background: var(--gradient-primary);
        }

        .role-card.selected .role-icon i {
            color: var(--white);
        }

        .role-icon i {
            font-size: 1.25rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            transition: var(--transition);
        }

        .role-name {
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--dark);
        }

        .role-card.selected .role-name {
            color: var(--primary);
        }

        /* Body */
        .auth-body {
            padding: 2rem;
        }

        /* Formulaires modernes */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--dark);
        }

        .form-label i {
            margin-right: 0.5rem;
            color: var(--primary);
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: var(--gray);
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .form-control:focus + .input-icon {
            color: var(--primary);
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.5rem;
            border: 1px solid #e2e8f0;
            font-size: 0.875rem;
            transition: var(--transition);
            background: var(--white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Checkbox modernisé */
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 0.875rem;
            color: var(--gray);
        }

        .checkbox-label input {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: var(--primary);
        }

        .forgot-link {
            font-size: 0.875rem;
            color: var(--primary);
            text-decoration: none;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .forgot-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Bouton Connexion moderne */
        .btn-login {
            width: 100%;
            padding: 0.875rem;
            background: var(--gradient-primary);
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
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            transition: all 0.5s ease;
            transform: translate(-50%, -50%);
        }

        .btn-login:hover::before {
            width: 100%;
            height: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-glow);
        }

        /* Alertes modernes */
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

        .alert-success {
            background: #ecfdf5;
            border-left: 3px solid var(--success);
            color: #065f46;
        }

        .alert-danger {
            background: #fef2f2;
            border-left: 3px solid var(--danger);
            color: #991b1b;
        }

        .alert-warning {
            background: #fffbeb;
            border-left: 3px solid var(--warning);
            color: #92400e;
        }

        /* Footer */
        .auth-footer {
            background: var(--gray-light);
            padding: 1.25rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--gray);
            border-top: 1px solid #e2e8f0;
        }

        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .auth-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .auth-footer p {
            margin: 0;
        }

        .auth-footer .mt-2 {
            margin-top: 0.75rem;
        }

        /* Bouton Retour Accueil moderne */
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

        /* Error message */
        .text-danger {
            color: var(--danger);
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: block;
        }

        /* Responsive */
        @media (max-width: 640px) {
            body {
                padding: 1rem;
            }
            
            .role-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .auth-header {
                padding: 1.5rem;
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
        }

        @media (max-width: 480px) {
            .role-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            
            .role-card {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 0.75rem;
            }
            
            .role-icon {
                margin: 0;
                width: 40px;
                height: 40px;
            }
            
            .role-name {
                text-align: left;
            }
            
            .checkbox-wrapper {
                flex-direction: column;
                gap: 0.75rem;
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
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1>Collège Notre-Dame de Grâce</h1>
                <p>Lubumbashi, République Démocratique du Congo</p>
            </div>

            <!-- Session Status -->
            @if(session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('status') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <!-- Role Selector -->
            <div class="role-selector">
                <div class="role-title">
                    <i class="fas fa-users"></i> Qui êtes-vous ?
                </div>
                <div class="role-grid">
                    <div class="role-card" data-role="gestionnaire_systeme">
                        <div class="role-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="role-name">Gestionnaire Système</div>
                    </div>
                    <div class="role-card" data-role="comptable">
                        <div class="role-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div class="role-name">Comptable</div>
                    </div>
                    <div class="role-card" data-role="parent">
                        <div class="role-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="role-name">Parent</div>
                    </div>
                    <div class="role-card" data-role="eleve">
                        <div class="role-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="role-name">Élève</div>
                    </div>
                </div>
            </div>

            <!-- Login Form -->
            <div class="auth-body">
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf
                    
                    <!-- Rôle caché -->
                    <input type="hidden" name="role" id="selectedRole" value="">

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-envelope"></i> Adresse email
                        </label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control" 
                                   placeholder="votre@email.com" value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <span class="text-danger">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock"></i> Mot de passe
                        </label>
                        <div class="input-group">
                            <i class="fas fa-key input-icon"></i>
                            <input type="password" name="password" id="password" class="form-control" 
                                   placeholder="••••••••" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-danger">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="checkbox-wrapper">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Se souvenir de moi</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                <i class="fas fa-question-circle"></i> Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Se connecter
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="auth-footer">
                <p>Vous n'avez pas de compte ? 
                    <a href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i> Créer un compte parent
                    </a>
                </p>
                <p class="mt-2">
                    <small>© {{ date('Y') }} Collège Notre-Dame de Grâce - Tous droits réservés</small>
                </p>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        // Gestion de la sélection du rôle
        const roleCards = document.querySelectorAll('.role-card');
        const selectedRoleInput = document.getElementById('selectedRole');
        let selectedRole = null;

        roleCards.forEach(card => {
            card.addEventListener('click', function() {
                // Retirer la classe selected de tous les cartes
                roleCards.forEach(c => c.classList.remove('selected'));
                
                // Ajouter la classe selected à la carte cliquée
                this.classList.add('selected');
                
                // Récupérer le rôle sélectionné
                selectedRole = this.getAttribute('data-role');
                selectedRoleInput.value = selectedRole;
                
                // Changer le placeholder de l'email selon le rôle
                const emailInput = document.querySelector('input[name="email"]');
                if (selectedRole === 'gestionnaire_systeme') {
                    emailInput.placeholder = 'gestionnaire@college-ndg.cd';
                } else if (selectedRole === 'comptable') {
                    emailInput.placeholder = 'comptable@college-ndg.cd';
                } else if (selectedRole === 'parent') {
                    emailInput.placeholder = 'parent@email.com';
                } else if (selectedRole === 'eleve') {
                    emailInput.placeholder = 'eleve@college-ndg.cd';
                }
            });
        });

        // Sélectionner le rôle par défaut s'il y a une erreur
        @if(old('role'))
            const defaultRole = "{{ old('role') }}";
            roleCards.forEach(card => {
                if (card.getAttribute('data-role') === defaultRole) {
                    card.classList.add('selected');
                    selectedRoleInput.value = defaultRole;
                }
            });
        @endif

        // Validation avant soumission
        const loginForm = document.getElementById('loginForm');
        loginForm.addEventListener('submit', function(e) {
            if (!selectedRoleInput.value) {
                e.preventDefault();
                const roleSelector = document.querySelector('.role-selector');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'alert alert-danger';
                errorDiv.style.marginTop = '1rem';
                errorDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> Veuillez sélectionner votre rôle.';
                roleSelector.parentNode.insertBefore(errorDiv, roleSelector.nextSibling);
                
                setTimeout(() => {
                    errorDiv.remove();
                }, 3000);
            }
        });

        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>