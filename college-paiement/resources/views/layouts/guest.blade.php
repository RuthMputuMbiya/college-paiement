{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Collège Notre-Dame de Grâce')</title>
    
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
            flex-direction: column;
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
        .card, .btn, input, select, textarea, .alert, .auth-logo, .back-home {
            border-radius: 0px !important;
        }

        /* ============================================
           CARTE PRINCIPALE CENTRÉE
        ============================================ */
        .auth-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            min-height: 100vh;
            position: relative;
            z-index: 10;
        }

        .auth-card {
            background: var(--white);
            max-width: 480px;
            width: 100%;
            margin: 0 auto;
            box-shadow: var(--shadow-xl);
            animation: fadeInUp 0.6s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            overflow: hidden;
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

        /* Header de la carte avec dégradé */
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

        /* Body de la carte */
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

        .form-control {
            width: 100%;
            padding: 0.875rem;
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

        /* Boutons modernes */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.875rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
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

        .btn:hover::before {
            width: 100%;
            height: 100%;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: var(--white);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-glow);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
            color: var(--white);
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
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

        .alert-error, .alert-danger {
            background: #fef2f2;
            border-left: 3px solid var(--danger);
            color: #991b1b;
        }

        .alert-warning {
            background: #fffbeb;
            border-left: 3px solid var(--warning);
            color: #92400e;
        }

        .alert-info {
            background: #eff6ff;
            border-left: 3px solid #3b82f6;
            color: #1e40af;
        }

        /* Liens */
        .auth-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .auth-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .auth-link a:hover {
            text-decoration: underline;
            color: var(--primary-dark);
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

        .auth-footer p {
            margin: 0;
        }

        /* Bouton retour moderne */
        .back-home {
            position: fixed;
            bottom: 2rem;
            left: 2rem;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--white);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: var(--transition);
            border: 1px solid rgba(255, 255, 255, 0.25);
            z-index: 100;
        }

        .back-home i {
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .back-home:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateX(-5px);
            color: var(--white);
            border-color: rgba(255, 255, 255, 0.4);
        }

        .back-home:hover i {
            transform: translateX(-3px);
        }

        /* Liste d'erreurs */
        .alert ul {
            margin-left: 1.5rem;
            margin-top: 0.5rem;
            margin-bottom: 0;
        }

        .alert li {
            font-size: 0.75rem;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .auth-container {
                padding: 1rem;
            }
            
            .auth-header {
                padding: 1.5rem;
            }
            
            .auth-body {
                padding: 1.5rem;
            }
            
            .back-home {
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
            
            .btn {
                padding: 0.75rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Bouton retour accueil -->
    <a href="{{ url('/') }}" class="back-home">
        <i class="fas fa-arrow-left"></i>
        <span>Retour à l'accueil</span>
    </a>

    <!-- Conteneur principal centré -->
    <div class="auth-container" data-aos="fade-up">
        <div class="auth-card">
            <!-- Header -->
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1>Collège Notre-Dame de Grâce</h1>
                <p>Lubumbashi, République Démocratique du Congo</p>
            </div>

            <!-- Body -->
            <div class="auth-body">
                <!-- Alertes -->
                @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
                @endif

                @if(session('warning'))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-times-circle"></i>
                    <strong>Veuillez corriger les erreurs :</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Contenu principal -->
                @yield('content')
            </div>

            <!-- Footer -->
            <div class="auth-footer">
                <p>&copy; {{ date('Y') }} Collège Notre-Dame de Grâce. Tous droits réservés.</p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
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
    @stack('scripts')
</body>
</html>