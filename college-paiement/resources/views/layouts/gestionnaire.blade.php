{{-- resources/views/layouts/gestionnaire.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gestionnaire - Collège NDG | @yield('title', 'Tableau de bord')</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            color: white;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s;
        }
        .sidebar-header { padding: 25px 20px; text-align: center; border-bottom: 1px solid #334155; }
        .sidebar-logo { font-size: 22px; font-weight: 800; }
        .sidebar-logo span { color: #4f46e5; }
        .sidebar-logo small { font-size: 10px; display: block; color: #64748b; margin-top: 5px; }
        .sidebar-user { padding: 20px; text-align: center; border-bottom: 1px solid #334155; }
        .user-avatar { width: 65px; height: 65px; background: #4f46e5; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 26px; font-weight: 700; }
        .user-name { font-weight: 600; font-size: 15px; }
        .user-role { font-size: 11px; color: #94a3b8; margin-top: 4px; }
        .sidebar-nav { padding: 20px 15px; }
        .nav-title { font-size: 10px; text-transform: uppercase; color: #64748b; padding: 0 15px; margin-bottom: 15px; letter-spacing: 1px; }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: #cbd5e1;
            text-decoration: none;
            margin-bottom: 5px;
            transition: all 0.3s;
        }
        .nav-link:hover { background: #1e293b; color: white; }
        .nav-link.active { background: #4f46e5; color: white; }
        .nav-link i { width: 20px; font-size: 16px; }
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
            padding: 12px 18px;
            background: none;
            border: none;
            color: #cbd5e1;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }
        .logout-btn:hover { background: #ef4444; color: white; }
        
        /* Main Content */
        .main-content { margin-left: 280px; padding: 20px; min-height: 100vh; }
        .top-bar {
            background: white;
            padding: 16px 25px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e2e8f0;
        }
        .page-title h2 { font-size: 18px; font-weight: 700; color: #0f172a; }
        .page-title p { font-size: 12px; color: #64748b; margin-top: 4px; }
        .date-badge { background: #f1f5f9; padding: 8px 18px; font-size: 13px; }
        .date-badge i { color: #4f46e5; margin-right: 8px; }
        .btn-mobile { display: none; background: none; border: none; font-size: 20px; cursor: pointer; }
        
        /* Cards */
        .card { background: white; border: 1px solid #e2e8f0; margin-bottom: 25px; overflow: hidden; }
        .card-header { padding: 18px 22px; border-bottom: 1px solid #e2e8f0; background: #f8fafc; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
        .card-header h3 { font-size: 16px; font-weight: 700; margin: 0; color: #1e293b; }
        .card-header h3 i { margin-right: 8px; color: #4f46e5; }
        .card-body { padding: 20px; }
        .card-footer { padding: 15px 22px; border-top: 1px solid #e2e8f0; background: #f8fafc; }
        
        /* Buttons */
        .btn-primary { background: #4f46e5; color: white; padding: 8px 20px; text-decoration: none; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer; transition: all 0.3s; }
        .btn-primary:hover { background: #4338ca; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(79,70,229,0.3); }
        .btn-outline { background: transparent; border: 1px solid #e2e8f0; padding: 7px 19px; color: #64748b; text-decoration: none; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s; cursor: pointer; }
        .btn-outline:hover { border-color: #ef4444; color: #ef4444; }
        .btn-danger { background: #ef4444; color: white; padding: 8px 20px; text-decoration: none; font-size: 13px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px; border: none; cursor: pointer; transition: all 0.3s; }
        .btn-danger:hover { background: #dc2626; transform: translateY(-2px); }
        
        /* Forms */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 8px; font-weight: 600; font-size: 13px; color: #1e293b; }
        .form-label.required::after { content: '*'; color: #ef4444; margin-left: 4px; }
        .form-label i { margin-right: 8px; color: #64748b; width: 18px; }
        .form-control { width: 100%; padding: 12px 15px; border: 1px solid #e2e8f0; font-size: 14px; transition: all 0.3s; background: white; }
        .form-control:focus { outline: none; border-color: #4f46e5; box-shadow: 0 0 0 2px rgba(79,70,229,0.1); }
        select.form-control { cursor: pointer; appearance: none; background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="%2364748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>'); background-repeat: no-repeat; background-position: right 12px center; }
        textarea.form-control { resize: vertical; }
        .form-actions { margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0; display: flex; gap: 15px; justify-content: flex-end; }
        .invalid-feedback { display: block; color: #ef4444; font-size: 11px; margin-top: 5px; }
        .form-hint { display: block; font-size: 11px; color: #64748b; margin-top: 5px; }
        .form-hint i { margin-right: 4px; }
        
        /* Tables */
        .table-responsive { overflow-x: auto; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background: #f8fafc; padding: 12px 15px; font-size: 12px; font-weight: 600; color: #64748b; text-align: left; }
        .data-table td { padding: 12px 15px; border-bottom: 1px solid #e2e8f0; font-size: 13px; vertical-align: middle; }
        .data-table tr:hover { background: #f8fafc; }
        
        /* Badges */
        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; font-size: 11px; font-weight: 500; }
        .badge-success { background: #d1fae5; color: #059669; }
        .badge-danger { background: #fee2e2; color: #dc2626; }
        .badge-warning { background: #fef3c7; color: #d97706; }
        .badge-info { background: #e0e7ff; color: #4f46e5; }
        
        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px; }
        .stat-card { background: white; padding: 20px; display: flex; align-items: center; gap: 15px; border: 1px solid #e2e8f0; transition: all 0.3s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .stat-icon { width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; }
        .stat-icon i { font-size: 24px; }
        .stat-info { flex: 1; }
        .stat-label { font-size: 11px; color: #64748b; text-transform: uppercase; margin-bottom: 5px; }
        .stat-value { font-size: 24px; font-weight: 800; color: #1e293b; }
        
        /* Alerts */
        .alert { padding: 15px 20px; margin-bottom: 25px; display: flex; align-items: center; gap: 12px; animation: slideIn 0.3s ease; border-left: 4px solid; }
        @keyframes slideIn { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .alert-success { background: #ecfdf5; border-left-color: #10b981; color: #065f46; }
        .alert-error { background: #fef2f2; border-left-color: #ef4444; color: #991b1b; }
        .alert-warning { background: #fffbeb; border-left-color: #f59e0b; color: #92400e; }
        
        /* Pagination */
        .pagination { display: flex; gap: 5px; list-style: none; }
        .page-item { display: inline-block; }
        .page-link { padding: 8px 12px; border: 1px solid #e2e8f0; color: #64748b; text-decoration: none; transition: all 0.3s; }
        .page-link:hover { background: #4f46e5; color: white; border-color: #4f46e5; }
        .page-item.active .page-link { background: #4f46e5; color: white; border-color: #4f46e5; }
        
        /* Action buttons */
        .action-buttons { display: flex; gap: 8px; }
        .action-btn { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; background: #f1f5f9; color: #64748b; border: none; cursor: pointer; transition: all 0.2s; }
        .action-btn.view:hover { background: #3b82f6; color: white; }
        .action-btn.edit:hover { background: #f59e0b; color: white; }
        .action-btn.delete:hover { background: #ef4444; color: white; }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s; }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .btn-mobile { display: block; }
            .top-bar { flex-direction: column; gap: 15px; text-align: center; }
            .stats-grid { grid-template-columns: 1fr; }
            .form-actions { flex-direction: column; }
            .btn-primary, .btn-outline, .btn-danger { justify-content: center; width: 100%; }
            .data-table { display: block; overflow-x: auto; }
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
        <a href="{{ route('gestionnaire.dashboard') }}" class="nav-link {{ request()->routeIs('gestionnaire.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Tableau de bord
        </a>
        <a href="{{ route('gestionnaire.users.index') }}" class="nav-link {{ request()->routeIs('gestionnaire.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Utilisateurs
        </a>
        <a href="{{ route('gestionnaire.payments.index') }}" class="nav-link {{ request()->routeIs('gestionnaire.payments.*') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i> Paiements
        </a>
        <a href="{{ route('gestionnaire.payment-config.index') }}" class="nav-link {{ request()->routeIs('gestionnaire.payment-config.*') ? 'active' : '' }}">
            <i class="fas fa-credit-card"></i> Configuration paiement
        </a>
        <a href="{{ route('gestionnaire.statistiques.index') }}" class="nav-link {{ request()->routeIs('gestionnaire.statistiques.*') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Statistiques
        </a>
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
            <div class="date-badge"><i class="fas fa-calendar-alt"></i> {{ now()->translatedFormat('d/m/Y') }}</div>
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
    @if(session('warning'))
    <div class="alert alert-warning"><i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}</div>
    @endif

    @yield('content')
</div>

<script>
    function toggleSidebar() { document.getElementById('sidebar').classList.toggle('open'); }
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const menuBtn = document.querySelector('.btn-mobile');
        if (window.innerWidth < 768 && sidebar && menuBtn && !sidebar.contains(event.target) && !menuBtn.contains(event.target)) {
            sidebar.classList.remove('open');
        }
    });
</script>
@stack('scripts')
</body>
</html>