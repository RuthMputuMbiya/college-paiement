{{-- resources/views/layouts/gestionnaire.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestionnaire - Collège NDG | @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        * { border-radius: 0px !important; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; }
        
        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            background: #0f172a;
            color: white;
            overflow-y: auto;
            z-index: 1000;
        }
        .sidebar-header { padding: 25px 20px; text-align: center; border-bottom: 1px solid #334155; }
        .sidebar-logo { font-size: 20px; font-weight: 700; }
        .sidebar-logo span { color: #4f46e5; }
        .sidebar-logo small { font-size: 10px; display: block; color: #64748b; margin-top: 5px; }
        .sidebar-user { padding: 20px; text-align: center; border-bottom: 1px solid #334155; }
        .user-avatar { width: 60px; height: 60px; background: #4f46e5; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 24px; font-weight: 700; }
        .user-name { font-weight: 600; font-size: 14px; }
        .user-role { font-size: 10px; color: #94a3b8; margin-top: 4px; }
        .sidebar-nav { padding: 20px; }
        .nav-title { font-size: 10px; text-transform: uppercase; color: #64748b; margin-bottom: 15px; letter-spacing: 1px; }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 15px;
            color: #cbd5e1;
            text-decoration: none;
            margin-bottom: 5px;
            transition: all 0.3s;
        }
        .nav-link:hover { background: #1e293b; color: white; }
        .nav-link.active { background: #4f46e5; color: white; }
        .nav-link i { width: 20px; font-size: 14px; }
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            border-top: 1px solid #334155;
        }
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 10px 15px;
            background: none;
            border: none;
            color: #cbd5e1;
            cursor: pointer;
            font-size: 14px;
        }
        .logout-btn:hover { background: #ef4444; color: white; }
        
        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 20px;
            min-height: 100vh;
        }
        .top-bar {
            background: white;
            padding: 15px 25px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e2e8f0;
        }
        .page-title h2 { font-size: 18px; font-weight: 700; color: #0f172a; }
        .page-title p { font-size: 12px; color: #64748b; margin-top: 4px; }
        .date-badge { background: #f1f5f9; padding: 8px 18px; font-size: 13px; }
        .date-badge i { color: #4f46e5; margin-right: 8px; }
        .alert { padding: 12px 20px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; font-size: 13px; }
        .alert-success { background: #d1fae5; color: #065f46; border-left: 3px solid #10b981; }
        .alert-error { background: #fee2e2; color: #991b1b; border-left: 3px solid #ef4444; }
        .btn-mobile { display: none; background: none; border: none; font-size: 20px; cursor: pointer; }
        
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .btn-mobile { display: block; }
            .top-bar { flex-direction: column; gap: 15px; text-align: center; }
        }
    </style>
    @stack('styles')
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">Collège <span>NDG</span></div>
        <small>Notre-Dame de Grâce</small>
    </div>
    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name ?? 'G', 0, 1)) }}</div>
        <div class="user-name">{{ Auth::user()->name ?? 'Gestionnaire' }}</div>
        <div class="user-role">Gestionnaire Système</div>
    </div>
    <div class="sidebar-nav">
        <div class="nav-title">Navigation</div>
        <a href="{{ url('/gestionnaire/dashboard') }}" class="nav-link"><i class="fas fa-chart-pie"></i> Tableau de bord</a>
        <a href="{{ url('/gestionnaire/users') }}" class="nav-link"><i class="fas fa-users"></i> Utilisateurs</a>
        <a href="{{ url('/gestionnaire/payments') }}" class="nav-link"><i class="fas fa-receipt"></i> Paiements</a>
        <a href="{{ url('/gestionnaire/payment-config') }}" class="nav-link"><i class="fas fa-credit-card"></i> Configuration paiement</a>
        <a href="{{ url('/gestionnaire/logs') }}" class="nav-link"><i class="fas fa-history"></i> Logs système</a>
    </div>
    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Déconnexion</button>
        </form>
    </div>
</div>

<div class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h2>@yield('page-title', 'Tableau de bord')</h2>
            <p>@yield('page-subtitle', 'Gestion du système de paiement scolaire')</p>
        </div>
        <div class="top-bar-right">
            <div class="date-badge"><i class="fas fa-calendar-alt"></i> {{ date('d/m/Y') }}</div>
            <button class="btn-mobile" onclick="document.getElementById('sidebar').classList.toggle('open')">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    @yield('content')
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }
</script>
@stack('scripts')
</body>
</html>