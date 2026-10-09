{{-- resources/views/partials/sidebar-parent.blade.php --}}
<aside class="sidebar">
    <div class="sidebar-header">
        <div class="logo-area">
            <div class="logo-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="logo-text">
                <h2>Espace Parent</h2>
                <p>Suivi scolaire</p>
            </div>
        </div>
        <div class="welcome-message">
            <i class="fas fa-hand-peace"></i>
            <span>Bienvenue, {{ Auth::user()->name ?? 'Parent' }}</span>
        </div>
    </div>
    
    <nav class="sidebar-nav">
        <a href="{{ route('parent.dashboard') }}" class="sidebar-link {{ request()->routeIs('parent.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i>
            <span>Tableau de bord</span>
        </a>
        
        <a href="{{ route('parent.enfants') }}" class="sidebar-link {{ request()->routeIs('parent.enfants') ? 'active' : '' }}">
            <i class="fas fa-child"></i>
            <span>Mes enfants</span>
            <i class="fas fa-chevron-right arrow-icon"></i>
        </a>
        
        <div class="divider"></div>
        
        <a href="{{ route('parent.paiement.form') }}" class="sidebar-link payment-link {{ request()->routeIs('parent.paiement.form') ? 'active' : '' }}">
            <i class="fas fa-credit-card"></i>
            <span>Effectuer un paiement</span>
            <i class="fas fa-arrow-right arrow-icon"></i>
        </a>
        
        <a href="{{ route('parent.historique') }}" class="sidebar-link {{ request()->routeIs('parent.historique') ? 'active' : '' }}">
            <i class="fas fa-history"></i>
            <span>Historique des paiements</span>
        </a>
        
        <a href="{{ route('parent.reçus') }}" class="sidebar-link {{ request()->routeIs('parent.reçus') ? 'active' : '' }}">
            <i class="fas fa-file-pdf"></i>
            <span>Mes reçus</span>
        </a>
        
        <div class="divider"></div>
        
        <div class="help-card">
            <i class="fas fa-headset"></i>
            <div class="help-content">
                <p class="help-title">Besoin d'aide ?</p>
                <p class="help-phone">
                    <i class="fas fa-phone-alt"></i> +243 123 456 789
                </p>
                <p class="help-hours">
                    <i class="fas fa-clock"></i> Lun-Ven: 8h - 16h
                </p>
                <a href="#" class="help-contact">
                    <i class="fas fa-envelope"></i> Contacter le support
                </a>
            </div>
        </div>
    </nav>
    
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name ?? 'P', 0, 1)) }}
            </div>
            <div class="user-details">
                <p class="user-name">{{ Auth::user()->name ?? 'Parent' }}</p>
                <p class="user-role">Parent d'élève</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Déconnexion</span>
            </button>
        </form>
    </div>
</aside>

<style>
    /* ============================================
       SIDEBAR PARENT - DESIGN MODERNE
       COINS CARRÉS - PROFESSIONNEL
    ============================================ */
    
    :root {
        --parent-primary: #8b5cf6;
        --parent-primary-dark: #7c3aed;
        --parent-primary-light: #a78bfa;
        --parent-secondary: #ec4899;
        --parent-secondary-dark: #db2777;
        --parent-accent: #f59e0b;
        --gradient-parent: linear-gradient(135deg, #6b21a5 0%, #7e22ce 50%, #db2777 100%);
        --gradient-hover: linear-gradient(135deg, #7c3aed 0%, #9333ea 50%, #ec4899 100%);
        --shadow-glow: 0 0 20px rgba(139, 92, 246, 0.3);
        --transition: all 0.3s ease;
    }

    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 280px;
        height: 100vh;
        background: var(--gradient-parent);
        color: var(--white);
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 4px 0 25px rgba(0, 0, 0, 0.15);
        transition: var(--transition);
    }

    /* Scrollbar personnalisée */
    .sidebar::-webkit-scrollbar {
        width: 5px;
    }
    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
    }
    .sidebar::-webkit-scrollbar-thumb {
        background: var(--parent-primary-light);
    }

    /* Sidebar Header */
    .sidebar-header {
        padding: 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 1rem;
    }

    .logo-area {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .logo-icon {
        width: 45px;
        height: 45px;
        background: rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo-icon i {
        font-size: 1.25rem;
        color: var(--white);
    }

    .logo-text h2 {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0;
        color: var(--white);
    }

    .logo-text p {
        font-size: 0.65rem;
        color: rgba(255, 255, 255, 0.6);
        margin: 0;
    }

    .welcome-message {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem;
        background: rgba(255, 255, 255, 0.08);
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .welcome-message i {
        color: var(--parent-accent);
    }

    /* Navigation */
    .sidebar-nav {
        padding: 0 0.75rem;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        font-size: 0.875rem;
        font-weight: 500;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .sidebar-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        transition: var(--transition);
        z-index: 0;
    }

    .sidebar-link:hover::before {
        width: 100%;
    }

    .sidebar-link i {
        width: 22px;
        font-size: 1rem;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .sidebar-link span {
        flex: 1;
        position: relative;
        z-index: 1;
    }

    .arrow-icon {
        width: auto !important;
        font-size: 0.7rem !important;
        opacity: 0.5;
        transition: var(--transition);
    }

    .sidebar-link:hover {
        color: var(--white);
        transform: translateX(3px);
    }

    .sidebar-link:hover .arrow-icon {
        opacity: 1;
        transform: translateX(3px);
    }

    .sidebar-link.active {
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.15) 0%, transparent 100%);
        color: var(--white);
        border-left: 3px solid var(--parent-accent);
    }

    /* Payment Link spécial */
    .payment-link {
        background: rgba(255, 255, 255, 0.08);
        margin: 0.5rem 0;
    }

    .payment-link i:first-child {
        color: var(--parent-accent);
    }

    /* Divider */
    .divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        margin: 1rem 0;
    }

    /* Help Card */
    .help-card {
        background: rgba(255, 255, 255, 0.08);
        padding: 1rem;
        margin-top: 1rem;
        display: flex;
        gap: 0.75rem;
    }

    .help-card > i {
        font-size: 1.5rem;
        color: var(--parent-accent);
    }

    .help-content {
        flex: 1;
    }

    .help-title {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--white);
        margin-bottom: 0.5rem;
    }

    .help-phone,
    .help-hours {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .help-phone i,
    .help-hours i {
        width: 16px;
        font-size: 0.65rem;
    }

    .help-contact {
        display: inline-block;
        margin-top: 0.5rem;
        font-size: 0.7rem;
        color: var(--parent-accent);
        text-decoration: none;
        transition: var(--transition);
    }

    .help-contact:hover {
        color: var(--white);
    }

    /* Sidebar Footer */
    .sidebar-footer {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(0, 0, 0, 0.2);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: var(--gradient-hover);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        box-shadow: var(--shadow-glow);
    }

    .user-details {
        flex: 1;
    }

    .user-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--white);
        margin: 0;
    }

    .user-role {
        font-size: 0.65rem;
        color: rgba(255, 255, 255, 0.5);
        margin: 0;
    }

    .logout-form {
        width: 100%;
    }

    .logout-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.5rem;
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #fca5a5;
        font-weight: 600;
        font-size: 0.75rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .logout-btn:hover {
        background: var(--danger, #ef4444);
        color: var(--white);
        border-color: transparent;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }
        
        .sidebar.mobile-open {
            transform: translateX(0);
        }
    }
</style>

<script>
    // Pour la compatibilité avec le toggle mobile du layout principal
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.querySelector('.mobile-toggle');
        
        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
            });
        }
        
        // Fermer le sidebar en cliquant à l'extérieur
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 768 && sidebar && !sidebar.contains(event.target) && !toggleBtn?.contains(event.target)) {
                sidebar.classList.remove('mobile-open');
            }
        });
    });
</script>