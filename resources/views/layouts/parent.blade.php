{{-- resources/views/layouts/parent.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Parent - Collège NDG | @yield('title', 'Tableau de bord')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <style>
        /* ========================================== */
        /* VARIABLES - COINS CARRÉS */
        /* ========================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        * {
            border-radius: 0px !important;
        }

        :root {
            --primary: #6b21a5;
            --primary-dark: #444047;
            --primary-light: #7e22ce;
            --secondary: #fbbf24;
            --secondary-dark: #d97706;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --dark: #0f172a;
            --dark-light: #1e293b;
            --gray: #64748b;
            --gray-light: #f1f5f9;
            --white: #ffffff;
            --gradient-primary: linear-gradient(135deg, #4a4151 0%, #414041 100%);
            --gradient-dark: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-light);
            min-height: 100vh;
        }

        /* ========================================== */
        /* SIDEBAR STYLES */
        /* ========================================== */
        .parent-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #2b2b2b 0%, #01243f 100%);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 25px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-logo {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .sidebar-logo span {
            color: var(--secondary);
        }

        .sidebar-logo small {
            font-size: 10px;
            display: block;
            color: rgba(255,255,255,0.5);
            margin-top: 6px;
        }

        .sidebar-user {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .user-avatar {
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 26px;
            font-weight: 700;
            box-shadow: 0 8px 20px rgba(251,191,36,0.3);
        }

        .user-name {
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 15px;
        }

        .user-role {
            font-size: 11px;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-nav {
            padding: 20px 15px;
        }

        .nav-title {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: rgba(255,255,255,0.4);
            padding: 0 15px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            margin-bottom: 6px;
            transition: all 0.2s ease;
            font-size: 14px;
            font-weight: 500;
        }

        .sidebar-nav .nav-link i {
            width: 22px;
            font-size: 16px;
            text-align: center;
        }

        .sidebar-nav .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(3px);
        }

        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-dark) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(251,191,36,0.3);
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.2);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.2s ease;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.8);
            color: white;
        }

        /* ========================================== */
        /* MAIN CONTENT */
        /* ========================================== */
        .parent-main {
            margin-left: 280px;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* ========================================== */
        /* TOP BAR */
        /* ========================================== */
        .top-bar {
            background: white;
            padding: 16px 25px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow);
            border: 1px solid #e2e8f0;
        }

        .page-title h2 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            color: var(--dark);
        }

        .page-title p {
            font-size: 12px;
            margin: 4px 0 0 0;
            color: var(--gray);
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .date-badge {
            background: var(--gray-light);
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 500;
            color: var(--dark);
            border: 1px solid #e2e8f0;
        }

        .date-badge i {
            color: var(--primary);
            margin-right: 8px;
        }

        .btn-menu-mobile {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            display: none;
        }

        /* ========================================== */
        /* ALERT MESSAGES */
        /* ========================================== */
        .alert-custom {
            padding: 15px 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .alert-success {
            background: #ecfdf5;
            border-left: 4px solid var(--success);
            color: #065f46;
        }

        .alert-error {
            background: #fef2f2;
            border-left: 4px solid var(--danger);
            color: #991b1b;
        }

        .alert-warning {
            background: #fffbeb;
            border-left: 4px solid var(--warning);
            color: #92400e;
        }

        /* ========================================== */
        /* SCROLLBAR */
        /* ========================================== */
        .parent-sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .parent-sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }
        .parent-sidebar::-webkit-scrollbar-thumb {
            background: var(--secondary);
        }

        /* ========================================== */
        /* CARD STYLES */
        /* ========================================== */
        .card {
            background: var(--white);
            border: 1px solid #e2e8f0;
            margin-bottom: 25px;
            overflow: hidden;
        }

        .card-header {
            padding: 18px 22px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .card-header h3 {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
            color: var(--dark);
        }

        .card-header h3 i {
            margin-right: 8px;
            color: var(--primary);
        }

        .card-body {
            padding: 20px;
        }

        .card-footer {
            padding: 15px 22px;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        /* ========================================== */
        /* BUTTONS */
        /* ========================================== */
        .btn-primary {
            background: var(--gradient-primary);
            border: none;
            padding: 10px 22px;
            color: white;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(107,33,165,0.3);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #e2e8f0;
            padding: 9px 21px;
            color: var(--gray);
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
            cursor: pointer;
        }

        .btn-outline:hover {
            border-color: var(--danger);
            color: var(--danger);
        }

        .btn-secondary {
            background: var(--secondary);
            border: none;
            padding: 10px 22px;
            color: var(--dark);
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: var(--secondary-dark);
            transform: translateY(-2px);
            color: white;
        }

        /* ========================================== */
        /* TABLES */
        /* ========================================== */
        .table-responsive {
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: #f8fafc;
            padding: 12px 15px;
            font-size: 12px;
            font-weight: 600;
            color: var(--gray);
            text-align: left;
        }

        .data-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            vertical-align: middle;
        }

        .data-table tr:hover {
            background: #f8fafc;
        }

        /* ========================================== */
        /* BADGES */
        /* ========================================== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 500;
        }

        .badge-success {
            background: #d1fae5;
            color: #059669;
        }

        .badge-danger {
            background: #fee2e2;
            color: #dc2626;
        }

        .badge-warning {
            background: #fef3c7;
            color: #d97706;
        }

        .badge-info {
            background: #e0e7ff;
            color: #4f46e5;
        }

        /* ========================================== */
        /* STATS GRID */
        /* ========================================== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon i {
            font-size: 24px;
        }

        .stat-info {
            flex: 1;
        }

        .stat-label {
            font-size: 11px;
            color: var(--gray);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 800;
            color: var(--dark);
        }

        .stat-details {
            font-size: 11px;
            color: var(--gray);
            margin-top: 5px;
        }

        /* ========================================== */
        /* QUICK ACTIONS */
        /* ========================================== */
        .quick-actions {
            background: var(--gradient-dark);
            padding: 25px;
            margin-bottom: 20px;
        }

        .quick-header {
            color: white;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .quick-header i {
            margin-right: 8px;
            color: var(--secondary);
        }

        .quick-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .quick-btn {
            background: rgba(255,255,255,0.1);
            padding: 10px 22px;
            color: white;
            text-decoration: none;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition);
        }

        .quick-btn:hover {
            background: var(--secondary);
            color: var(--dark);
            transform: translateY(-2px);
        }

        /* ========================================== */
        /* RESPONSIVE */
        /* ========================================== */
        @media (max-width: 768px) {
            .parent-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .parent-sidebar.mobile-open {
                transform: translateX(0);
            }
            .parent-main {
                margin-left: 0;
            }
            .btn-menu-mobile {
                display: block;
            }
            .top-bar {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .quick-grid {
                flex-direction: column;
            }
            .quick-btn {
                justify-content: center;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <div class="parent-sidebar" :class="{'mobile-open': sidebarOpen}" x-data="{ sidebarOpen: false }">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                Collège <span>NDG</span>
                <small>Notre-Dame de Grâce</small>
            </div>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
            </div>
            <div class="user-name">{{ Auth::user()->name ?? 'Parent' }}</div>
            <div class="user-role">Parent d'élève</div>
        </div>

        <div class="sidebar-nav">
            <div class="nav-title">
                <i class="fas fa-circle" style="font-size: 6px;"></i> Navigation
            </div>
            
            <a href="{{ route('parent.dashboard') }}" class="nav-link {{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Tableau de bord
            </a>
            
            <a href="{{ route('parent.enfants') }}" class="nav-link {{ request()->routeIs('parent.enfants') ? 'active' : '' }}">
                <i class="fas fa-child"></i> Mes enfants
            </a>
            
            <a href="{{ route('parent.paiement.form') }}" class="nav-link {{ request()->routeIs('parent.paiement.*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i> Effectuer un paiement
            </a>
            
            <a href="{{ route('parent.historique') }}" class="nav-link {{ request()->routeIs('parent.historique') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Historique
            </a>
            
            <a href="{{ route('parent.profile.edit') }}" class="nav-link {{ request()->routeIs('parent.profile.*') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Mon profil
            </a>
        </div>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="parent-main">
        <div class="top-bar">
            <div class="page-title">
                <h2>@yield('page-title', 'Tableau de bord')</h2>
                <p>@yield('page-subtitle', 'Espace parent d\'élève')</p>
            </div>
            <div class="top-bar-right">
                <div class="date-badge">
                    <i class="fas fa-calendar-alt"></i>
                    {{ now()->translatedFormat('l d F Y') }}
                </div>
                <button class="btn-menu-mobile" @click="sidebarOpen = !sidebarOpen">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>

        @if(session('success'))
        <div class="alert-custom alert-success">
            <i class="fas fa-check-circle"></i>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        @if(session('error'))
        <div class="alert-custom alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>{{ session('error') }}</div>
        </div>
        @endif

        @if(session('warning'))
        <div class="alert-custom alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div>{{ session('warning') }}</div>
        </div>
        @endif

        @yield('content')
    </div>

    <script>
        AOS.init({ duration: 800, once: true });
        
        document.querySelector('.btn-menu-mobile')?.addEventListener('click', function() {
            document.querySelector('.parent-sidebar')?.classList.toggle('mobile-open');
        });
        
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.parent-sidebar');
            const menuBtn = document.querySelector('.btn-menu-mobile');
            if (window.innerWidth < 768 && sidebar && !sidebar.contains(event.target) && !menuBtn?.contains(event.target)) {
                sidebar.classList.remove('mobile-open');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>