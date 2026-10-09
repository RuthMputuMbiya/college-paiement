{{-- resources/views/auth/reset-password.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nouveau mot de passe - Collège Notre-Dame de Grâce</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #1e3a5f;
            --primary-dark: #0f2b48;
            --secondary: #10b981;
            --secondary-dark: #059669;
            --accent: #f59e0b;
            --danger: #ef4444;
            --dark: #0f172a;
            --gray: #64748b;
            --gray-light: #f1f5f9;
            --white: #ffffff;
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        * { border-radius: 0px !important; }

        .auth-container {
            width: 100%;
            max-width: 480px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-card {
            background: var(--white);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .auth-header {
            background: var(--primary);
            padding: 2rem;
            text-align: center;
            border-bottom: 3px solid var(--accent);
        }

        .auth-logo {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .auth-logo i { font-size: 2rem; color: var(--white); }
        .auth-header h1 { color: var(--white); font-size: 1.5rem; font-weight: 700; }
        .auth-header p { color: rgba(255, 255, 255, 0.7); font-size: 0.875rem; }

        .auth-body { padding: 2rem; }

        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--dark);
        }
        .form-label i { margin-right: 0.5rem; color: var(--gray); }

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
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #e2e8f0;
            font-size: 0.875rem;
            transition: var(--transition);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(30, 58, 95, 0.1);
        }

        .btn-submit {
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

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .alert {
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            border-left: 3px solid;
            font-size: 0.875rem;
        }
        .alert-success { background: #ecfdf5; border-left-color: var(--secondary); color: #065f46; }
        .alert-danger { background: #fef2f2; border-left-color: var(--danger); color: #991b1b; }

        .auth-footer {
            background: var(--gray-light);
            padding: 1rem;
            text-align: center;
            font-size: 0.75rem;
            color: var(--gray);
            border-top: 1px solid #e2e8f0;
        }

        .password-strength {
            margin-top: 0.5rem;
        }
        .strength-bar {
            height: 3px;
            background: #e2e8f0;
            margin-bottom: 0.5rem;
        }
        .strength-bar-fill {
            height: 100%;
            width: 0%;
            transition: var(--transition);
        }
        .strength-text {
            font-size: 0.7rem;
            color: var(--gray);
        }

        @media (max-width: 640px) {
            body { padding: 1rem; }
            .auth-header { padding: 1.5rem; }
            .auth-body { padding: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo"><i class="fas fa-lock"></i></div>
                <h1>Nouveau mot de passe</h1>
                <p>Choisissez un mot de passe sécurisé</p>
            </div>

            <div class="auth-body">
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-envelope"></i> Email</label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ $request->email ?? old('email') }}" required>
                        </div>
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-lock"></i> Nouveau mot de passe</label>
                        <div class="input-group">
                            <i class="fas fa-key input-icon"></i>
                            <input type="password" name="password" id="password" class="form-control" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-strength" id="passwordStrength">
                            <div class="strength-bar"><div class="strength-bar-fill" id="strengthFill"></div></div>
                            <div class="strength-text" id="strengthText">Entrez un mot de passe sécurisé</div>
                        </div>
                        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label"><i class="fas fa-check-circle"></i> Confirmer le mot de passe</label>
                        <div class="input-group">
                            <i class="fas fa-check-circle input-icon"></i>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Réinitialiser le mot de passe
                    </button>
                </form>
            </div>

            <div class="auth-footer">
                <p>© {{ date('Y') }} Collège Notre-Dame de Grâce</p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');
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

        // Password strength
        const passwordInput = document.getElementById('password');
        const strengthFill = document.getElementById('strengthFill');
        const strengthText = document.getElementById('strengthText');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length === 0) {
                strengthFill.style.width = '0%';
                strengthText.innerHTML = 'Entrez un mot de passe sécurisé';
                strengthText.style.color = 'var(--gray)';
                return;
            }
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
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
    </script>
</body>
</html>