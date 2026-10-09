{{-- resources/views/auth/forgot-password.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mot de passe oublié - Collège Notre-Dame de Grâce</title>
    
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
            /* Couleurs principales - Dégradé moderne */
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
        .auth-card, .btn, input, select, textarea, .alert, .info-box, .auth-logo {
            border-radius: 0px !important;
        }

        .auth-container {
            width: 100%;
            max-width: 480px;
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

        /* Body */
        .auth-body {
            padding: 2rem;
        }

        /* Info Box moderne */
        .info-box {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.08) 0%, rgba(6, 182, 212, 0.08) 100%);
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            border-left: 3px solid var(--primary);
        }

        .info-icon {
            color: var(--primary);
            font-size: 1.25rem;
        }

        .info-text {
            font-size: 0.875rem;
            color: var(--dark);
            line-height: 1.5;
        }

        /* Formulaires modernes */
        .form-group {
            margin-bottom: 1.5rem;
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

        .form-control.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.7rem;
            margin-top: 0.25rem;
            display: block;
        }

        /* Bouton moderne */
        .btn-submit {
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

        .btn-submit::before {
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

        .btn-submit:hover::before {
            width: 100%;
            height: 100%;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-glow);
        }

        /* Alertes modernes */
        .alert {
            padding: 0.875rem 1rem;
            margin-bottom: 1.25rem;
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

        /* Footer */
        .auth-footer {
            background: var(--gray-light);
            padding: 1rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--gray);
            border-top: 1px solid #e2e8f0;
        }

        .auth-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        /* Bouton Retour moderne */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            color: var(--gray);
            text-decoration: none;
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .back-link i {
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--primary);
        }

        .back-link:hover i {
            transform: translateX(-3px);
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
        @media (max-width: 640px) {
            body {
                padding: 1rem;
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
            .auth-body {
                padding: 1rem;
            }
            
            .info-box {
                padding: 0.75rem;
            }
            
            .info-text {
                font-size: 0.75rem;
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

    <div class="auth-container" data-aos="fade-up">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fas fa-key"></i>
                </div>
                <h1>Mot de passe oublié ?</h1>
                <p>Réinitialisez votre mot de passe</p>
            </div>

            <!-- Body -->
            <div class="auth-body">
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

                <!-- Info Box -->
                <div class="info-box">
                    <div class="info-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="info-text">
                        Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
                    </div>
                </div>

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-envelope"></i> Adresse email
                        </label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   placeholder="votre@email.com" value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <span class="invalid-feedback">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        Envoyer le lien de réinitialisation
                    </button>

                    <!-- Back to Login -->
                    <div class="text-center mt-4">
                        <a href="{{ route('login') }}" class="back-link">
                            <i class="fas fa-arrow-left"></i>
                            Retour à la connexion
                        </a>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="auth-footer">
                <p>© {{ date('Y') }} Collège Notre-Dame de Grâce - Tous droits réservés</p>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialiser AOS
        AOS.init({ duration: 800, once: true });

        // Auto-fermeture des alertes après 5 secondes
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    if (alert.parentNode) alert.remove();
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html>