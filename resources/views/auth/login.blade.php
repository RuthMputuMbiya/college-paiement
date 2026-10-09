{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - Collège Notre-Dame de Grâce</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0a73a3;
            --primary-dark: #065a82;
            --primary-light: #e0f2fe;
            --success: #10b981;
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
            
            --gradient-primary: linear-gradient(135deg, #07577f 0%, #425371 100%);
            --gradient-bg: linear-gradient(135deg, #064663 0%, #e0e7f2 50%, #053b57 100%);
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

        .auth-container {
            width: 100%;
            max-width: 450px;
            position: relative;
            z-index: 10;
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-card {
            background: var(--white);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            border-radius: 20px !important;
        }

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
            border-radius: 20px !important;
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

        .auth-body {
            padding: 2rem;
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
            border-radius: 12px !important;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(10, 115, 163, 0.1);
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
            color: var(--gray-500);
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

        .btn-login {
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
            border-radius: 12px !important;
        }

        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .alert {
            padding: 0.875rem 1rem;
            margin: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            animation: slideIn 0.3s ease;
            border-radius: 12px !important;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
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

        .text-danger {
            color: var(--danger);
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: block;
        }

        .auth-footer {
            background: var(--gray-900);
            padding: 1.25rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--gray-400);
        }

        .auth-footer a {
            color: var(--primary);
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
            margin-top: 0.75rem;
        }

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

        .back-home-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateX(-5px);
            color: var(--white);
        }

        @media (max-width: 640px) {
            body { padding: 1rem; }
            .auth-header { padding: 1.5rem; }
            .auth-body { padding: 1.5rem; }
            .auth-logo { width: 60px; height: 60px; }
            .auth-logo i { font-size: 1.75rem; }
            .auth-header h1 { font-size: 1.25rem; }
            .back-home-btn { bottom: 1rem; left: 1rem; padding: 0.5rem 1rem; font-size: 0.75rem; }
        }
    </style>
</head>
<body>
    <a href="{{ url('/') }}" class="back-home-btn">
        <i class="fas fa-arrow-left"></i>
        <span>Retour à l'accueil</span>
    </a>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1>Collège Notre-Dame de Grâce</h1>
                <p>Lubumbashi, République Démocratique du Congo</p>
            </div>

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

            <div class="auth-body">
                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

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
                            <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-lock"></i> Mot de passe
                        </label>
                        <div class="input-group">
                            <i class="fas fa-key input-icon"></i>
                            <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-danger"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                        @enderror
                    </div>

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

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Se connecter
                    </button>
                </form>
            </div>

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
        AOS.init({ duration: 600, once: true });

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