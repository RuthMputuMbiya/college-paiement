{{-- resources/views/layouts/comptable.blade.php --}}
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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f2f5 0%, #e8ecf1 100%);
            min-height: 100vh;
        }

        /* ========================================== */
        /* SIDEBAR STYLES - COINS CARRÉS */
        /* ========================================== */
        .comptable-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #1a1c1b 0%, #0d5934 100%);
            color: white;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 25px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .sidebar-logo {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .sidebar-logo span {
            color: #fbbf24;
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
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .user-avatar {
            width: 65px;
            height: 65px;
            background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
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
            background: rgba(255,255,255,0.08);
            color: white;
            transform: translateX(3px);
        }

        .sidebar-nav .nav-link.active {
            background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(251,191,36,0.3);
        }

        .submenu {
            margin-left: 35px;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        .submenu .nav-link {
            padding: 10px 18px;
            font-size: 13px;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        .ms-auto {
            margin-left: auto;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.08);
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
        .comptable-main {
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.03);
        }

        .page-title h2 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
            color: #1e293b;
        }

        .page-title p {
            font-size: 12px;
            margin: 4px 0 0 0;
            color: #64748b;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .date-badge {
            background: #f8fafc;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 500;
            color: #1e293b;
            border: 1px solid #e2e8f0;
        }

        .date-badge i {
            color: #fbbf24;
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
            border-left: 4px solid #10b981;
            color: #065f46;
        }

        .alert-error {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            color: #991b1b;
        }

        .alert-warning {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            color: #92400e;
        }

        /* ========================================== */
        /* SCROLLBAR */
        /* ========================================== */
        .comptable-sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .comptable-sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.05);
        }
        .comptable-sidebar::-webkit-scrollbar-thumb {
            background: #fbbf24;
        }

        /* ========================================== */
        /* RESPONSIVE */
        /* ========================================== */
        @media (max-width: 768px) {
            .comptable-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .comptable-sidebar.mobile-open {
                transform: translateX(0);
            }
            .comptable-main {
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
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <div class="comptable-sidebar" :class="{'mobile-open': sidebarOpen}" x-data="{ sidebarOpen: false }">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                Collège <span>NDG</span>
                <small>Notre-Dame de Grâce</small>
            </div>
        </div>

        <div class="sidebar-user">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'C', 0, 1)) }}
            </div>
            <div class="user-name">{{ Auth::user()->name ?? 'Comptable' }}</div>
            <div class="user-role">Comptable</div>
        </div>

        <div class="sidebar-nav">
            <div class="nav-title">
                <i class="fas fa-circle text-[6px] mr-2"></i> Navigation
            </div>
            
            <a href="{{ route('comptable.dashboard') }}" class="nav-link {{ request()->routeIs('comptable.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Tableau de bord
            </a>
            
            <!-- Gestion des parents - AJOUTÉ -->
            <a href="{{ route('comptable.parents.index') }}" class="nav-link {{ request()->routeIs('comptable.parents.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Gestion des parents
            </a>
            
            <a href="{{ route('comptable.eleves.index') }}" class="nav-link {{ request()->routeIs('comptable.eleves.*') ? 'active' : '' }}">
                <i class="fas fa-child"></i> Gestion des élèves
            </a>
            
            <a href="{{ route('comptable.classes.index') }}" class="nav-link {{ request()->routeIs('comptable.classes.*') ? 'active' : '' }}">
                <i class="fas fa-building"></i> Gestion des classes
            </a>
            
            <a href="{{ route('comptable.frais.index') }}" class="nav-link {{ request()->routeIs('comptable.frais.*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i> Gestion des frais
            </a>
            
            <a href="{{ route('comptable.paiements.index') }}" class="nav-link {{ request()->routeIs('comptable.paiements.*') ? 'active' : '' }}">
                <i class="fas fa-receipt"></i> Paiements
            </a>
            
            <a href="{{ route('comptable.litiges.index') }}" class="nav-link {{ request()->routeIs('comptable.litiges.*') ? 'active' : '' }}">
                <i class="fas fa-gavel"></i> Litiges
            </a>
            
            <a href="{{ route('comptable.statistiques.index') }}" class="nav-link {{ request()->routeIs('comptable.statistiques.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Statistiques
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
    <div class="comptable-main">
        <div class="top-bar">
            <div class="page-title">
                <h2>@yield('page-title', 'Tableau de bord')</h2>
                <p>@yield('page-subtitle', 'Gestion comptable du système de paiement scolaire')</p>
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
        <div class="alert-custom alert-success" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <i class="fas fa-check-circle"></i>
            <div>{{ session('success') }}</div>
            <button @click="show = false" class="ms-auto bg-transparent border-0 text-xl" style="margin-left: auto;">&times;</button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert-custom alert-error" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <i class="fas fa-exclamation-circle"></i>
            <div>{{ session('error') }}</div>
            <button @click="show = false" class="ms-auto bg-transparent border-0 text-xl" style="margin-left: auto;">&times;</button>
        </div>
        @endif

        @yield('content')
    </div>

    <script>
        AOS.init({ duration: 800, once: true });
        
        document.querySelector('.btn-menu-mobile')?.addEventListener('click', function() {
            document.querySelector('.comptable-sidebar')?.classList.toggle('mobile-open');
        });
        
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.comptable-sidebar');
            const menuBtn = document.querySelector('.btn-menu-mobile');
            if (window.innerWidth < 768 && sidebar && !sidebar.contains(event.target) && !menuBtn?.contains(event.target)) {
                sidebar.classList.remove('mobile-open');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>