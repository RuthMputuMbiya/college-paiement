{{-- resources/views/layouts/sidebar-comptable.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Comptable - Collège NDG | @yield('title', 'Tableau de bord')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

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
            --primary: #06b6d4;
            --primary-dark: #0891b2;
            --primary-light: #22d3ee;
            --secondary: #3b82f6;
            --secondary-dark: #2563eb;
            --accent: #f59e0b;
            --accent-light: #fbbf24;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --dark: #1e293b;
            --dark-light: #334155;
            --gray: #64748b;
            --gray-light: #f8fafc;
            --white: #ffffff;
            
            /* Dégradés */
            --gradient-primary: linear-gradient(135deg, #06b6d4 0%, #3b82f6 50%, #8b5cf6 100%);
            --gradient-dark: linear-gradient(180deg, #164e63 0%, #155e75 100%);
            --gradient-card: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            
            /* Ombres */
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --shadow-glow: 0 0 20px rgba(6, 182, 212, 0.3);
            
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #ecfeff 0%, #cffafe 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Coins carrés */
        .sidebar, .sidebar-header, .user-avatar, .nav-link, .submenu,
        .top-bar, .stat-card, .chart-card, .data-card, .quick-btn,
        .btn-primary, .btn-secondary, .alert-custom, .payment-card {
            border-radius: 0px !important;
        }

        /* ========================================== */
        /* SIDEBAR STYLES - MODERNE BLEU/CYAN */
        /* ========================================== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: var(--gradient-dark);
            color: var(--white);
            transition: var(--transition);
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.15);
        }

        /* Scrollbar personnalisée */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: var(--primary);
        }

        /* Sidebar Header */
        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 1.5rem;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            text-decoration: none;
            margin-bottom: 0.5rem;
        }

        .logo-icon {
            width: 45px;
            height: 45px;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-glow);
        }

        .logo-icon i {
            font-size: 1.25rem;
            color: var(--white);
        }

        .logo-text {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: -0.5px;
        }

        .logo-text span {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .sidebar-subtitle {
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 1px;
        }

        /* User Info */
        .sidebar-user {
            padding: 0 1.25rem 1.25rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 1rem;
        }

        .user-avatar {
            width: 65px;
            height: 65px;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
            font-size: 1.5rem;
            font-weight: 700;
            box-shadow: var(--shadow-glow);
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .user-role {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .user-role i {
            color: var(--primary-light);
        }

        /* Navigation */
        .sidebar-nav {
            padding: 0 0.75rem;
        }

        .nav-section {
            margin-bottom: 1.5rem;
        }

        .nav-title {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255, 255, 255, 0.4);
            padding: 0 0.75rem;
            margin-bottom: 0.75rem;
            font-weight: 600;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            margin-bottom: 0.25rem;
            transition: var(--transition);
            font-size: 0.875rem;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background: rgba(6, 182, 212, 0.15);
            transition: var(--transition);
            z-index: -1;
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link i {
            width: 22px;
            font-size: 1rem;
            text-align: center;
            transition: var(--transition);
        }

        .nav-link:hover {
            color: var(--white);
            transform: translateX(3px);
        }

        .nav-link:hover i {
            color: var(--primary-light);
        }

        .nav-link.active {
            background: linear-gradient(90deg, rgba(6, 182, 212, 0.2) 0%, transparent 100%);
            color: var(--white);
            border-left: 3px solid var(--primary);
        }

        .nav-link.active i {
            color: var(--primary-light);
        }

        /* Submenu */
        .submenu {
            margin-left: 2rem;
            margin-top: 0.25rem;
            margin-bottom: 0.25rem;
        }

        .submenu .nav-link {
            padding: 0.6rem 1rem;
            font-size: 0.8rem;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(0, 0, 0, 0.2);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .logout-btn:hover {
            background: var(--danger);
            color: var(--white);
            border-color: transparent;
            transform: translateY(-2px);
        }

        /* ========================================== */
        /* MAIN CONTENT */
        /* ========================================== */
        .main-content {
            margin-left: 280px;
            padding: 1rem;
            min-height: 100vh;
            transition: var(--transition);
        }

        /* ========================================== */
        /* TOP BAR MODERNE */
        /* ========================================== */
        .top-bar {
            background: var(--white);
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .page-title h2 {
            font-size: 1.125rem;
            font-weight: 700;
            margin: 0;
            color: var(--dark);
        }

        .page-title p {
            font-size: 0.75rem;
            margin: 0.25rem 0 0 0;
            color: var(--gray);
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .date-badge {
            background: var(--gray-light);
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--dark);
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .date-badge i {
            color: var(--primary);
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            color: var(--dark);
            padding: 0.5rem;
        }

        /* ========================================== */
        /* ALERT MESSAGES */
        /* ========================================== */
        .alert-custom {
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
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

        .alert-error {
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
            border-left: 3px solid var(--info);
            color: #1e40af;
        }

        /* ========================================== */
        /* CARDS MODERNES */
        /* ========================================== */
        .stat-card {
            background: var(--white);
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(6, 182, 212, 0.1);
        }

        .stat-icon i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .stat-info {
            flex: 1;
        }

        .stat-label {
            font-size: 0.7rem;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--dark);
        }

        /* Payment Card */
        .payment-card {
            background: var(--white);
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
        }

        .payment-card:hover {
            background: var(--gray-light);
        }

        /* Data Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: var(--gray-light);
            padding: 0.75rem 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray);
            text-align: left;
        }

        .data-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e2e8f0;
            font-size: 0.875rem;
        }

        /* ========================================== */
        /* RESPONSIVE */
        /* ========================================== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-toggle {
                display: block;
            }
            
            .top-bar {
                flex-direction: column;
                gap: 0.75rem;
                text-align: center;
            }
            
            .top-bar-right {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .top-bar {
                padding: 0.75rem 1rem;
            }
            
            .date-badge span {
                display: none;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar" :class="{'mobile-open': sidebarOpen}" x-data="{ sidebarOpen: false }">
        <div class="sidebar-header">
            <a href="{{ route('comptable.dashboard') }}" class="sidebar-logo">
                <div class="logo-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <div class="logo-text">Collège <span>NDG</span></div>
            </a>
            <div class="sidebar-subtitle">Espace Comptable</div>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'C', 0, 1)) }}
            </div>
            <div class="user-name">{{ Auth::user()->name ?? 'Comptable' }}</div>
            <div class="user-role">
                <i class="fas fa-calculator"></i> Comptable
            </div>
        </div>

        <div class="sidebar-nav">
            <div class="nav-section">
                <div class="nav-title">
                    <i class="fas fa-chart-line"></i> Tableau de bord
                </div>
                <a href="{{ route('comptable.dashboard') }}" class="nav-link {{ request()->routeIs('comptable.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i>
                    <span>Tableau de bord</span>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-title">
                    <i class="fas fa-receipt"></i> Transactions
                </div>
                <a href="{{ route('comptable.paiements.index') }}" class="nav-link {{ request()->routeIs('comptable.paiements.*') ? 'active' : '' }}">
                    <i class="fas fa-list-alt"></i>
                    <span>Tous les paiements</span>
                </a>
                <a href="{{ route('comptable.paiements.attente') }}" class="nav-link">
                    <i class="fas fa-clock"></i>
                    <span>Paiements en attente</span>
                </a>
                <a href="{{ route('comptable.paiements.valides') }}" class="nav-link">
                    <i class="fas fa-check-circle"></i>
                    <span>Paiements validés</span>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-title">
                    <i class="fas fa-chart-bar"></i> Rapports
                </div>
                <a href="{{ route('comptable.rapports.journalier') }}" class="nav-link">
                    <i class="fas fa-calendar-day"></i>
                    <span>Rapport journalier</span>
                </a>
                <a href="{{ route('comptable.rapports.mensuel') }}" class="nav-link">
                    <i class="fas fa-calendar-month"></i>
                    <span>Rapport mensuel</span>
                </a>
                <a href="{{ route('comptable.rapports.annuel') }}" class="nav-link">
                    <i class="fas fa-calendar-year"></i>
                    <span>Rapport annuel</span>
                </a>
                <div x-data="{ open: false }">
                    <a href="#" @click.prevent="open = !open" class="nav-link">
                        <i class="fas fa-download"></i>
                        <span>Exports</span>
                        <i class="fas fa-chevron-down ms-auto" :class="{'rotate-180': open}" style="margin-left: auto; transition: transform 0.2s;"></i>
                    </a>
                    <div x-show="open" x-collapse class="submenu">
                        <a href="{{ route('comptable.exports.excel') }}" class="nav-link">
                            <i class="fas fa-file-excel"></i>
                            <span>Export Excel</span>
                        </a>
                        <a href="{{ route('comptable.exports.pdf') }}" class="nav-link">
                            <i class="fas fa-file-pdf"></i>
                            <span>Export PDF</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-title">
                    <i class="fas fa-cog"></i> Configuration
                </div>
                <a href="{{ route('comptable.frais.index') }}" class="nav-link">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Frais scolaires</span>
                </a>
                <a href="{{ route('comptable.classes.index') }}" class="nav-link">
                    <i class="fas fa-building"></i>
                    <span>Classes</span>
                </a>
                <a href="{{ route('comptable.eleves.index') }}" class="nav-link">
                    <i class="fas fa-child"></i>
                    <span>Élèves</span>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-title">
                    <i class="fas fa-user"></i> Mon compte
                </div>
                <a href="{{ route('comptable.profile') }}" class="nav-link">
                    <i class="fas fa-user-circle"></i>
                    <span>Mon profil</span>
                </a>
                <a href="{{ route('comptable.password') }}" class="nav-link">
                    <i class="fas fa-key"></i>
                    <span>Changer mot de passe</span>
                </a>
            </div>
        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">
                <h2>@yield('page-title', 'Tableau de bord')</h2>
                <p>@yield('page-subtitle', 'Espace comptable - Gestion financière')</p>
            </div>
            <div class="top-bar-right">
                <div class="date-badge">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->translatedFormat('l d F Y') }}</span>
                </div>
                <button class="mobile-toggle" @click="sidebarOpen = !sidebarOpen">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        @if(session('success'))
        <div class="alert-custom alert-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <i class="fas fa-check-circle"></i>
            <div>{{ session('success') }}</div>
            <button @click="show = false" style="margin-left: auto; background: none; border: none; cursor: pointer;">&times;</button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert-custom alert-error" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <i class="fas fa-exclamation-circle"></i>
            <div>{{ session('error') }}</div>
            <button @click="show = false" style="margin-left: auto; background: none; border: none; cursor: pointer;">&times;</button>
        </div>
        @endif

        @if(session('warning'))
        <div class="alert-custom alert-warning" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <i class="fas fa-exclamation-triangle"></i>
            <div>{{ session('warning') }}</div>
            <button @click="show = false" style="margin-left: auto; background: none; border: none; cursor: pointer;">&times;</button>
        </div>
        @endif

        @yield('content')
    </div>

    <script>
        // Initialiser AOS
        AOS.init({ duration: 800, once: true });
        
        // Fermer le sidebar mobile en cliquant à l'extérieur
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const menuBtn = document.querySelector('.mobile-toggle');
            if (window.innerWidth < 768 && sidebar && !sidebar.contains(event.target) && !menuBtn?.contains(event.target)) {
                sidebar.classList.remove('mobile-open');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>