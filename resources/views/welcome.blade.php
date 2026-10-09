<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Collège Notre-Dame de Grâce | Paiements scolaires par Mobile Money - Lubumbashi</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #FFFFFF;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        :root {
            --primary: #09649c;
            --primary-dark: #091E2B;
            --primary-light: #1A4058;
            --secondary: #D4AF37;
            --secondary-dark: #B8960C;
            --secondary-light: #E8C97A;
            --white: #FFFFFF;
            --gray-50: #FAFAFA;
            --gray-100: #F5F5F5;
            --gray-200: #EEEEEE;
            --gray-300: #E0E0E0;
            --gray-600: #757575;
            --gray-800: #424242;
            --gray-900: #212121;
            --success: #27AE60;
            --danger: #E74C3C;
        }
        
        h1, h2, h3, .logo-text h1 {
            font-family: 'Playfair Display', serif;
        }
        
        /* ========== NAVIGATION ========== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: var(--white);
            z-index: 1000;
            padding: 1.2rem 0;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .navbar.scrolled {
            padding: 0.8rem 0;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        }
        
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary);
            font-size: 24px;
        }
        
        .logo-text h1 {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--primary);
            margin: 0;
            letter-spacing: -0.5px;
        }
        
        .logo-text p {
            font-size: 0.65rem;
            color: var(--secondary);
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--gray-800);
            font-weight: 500;
            transition: color 0.3s;
            font-size: 0.9rem;
        }
        
        .nav-links a:hover {
            color: var(--secondary);
        }
        
        .btn {
            padding: 0.7rem 1.8rem;
            border-radius: 40px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            border: none;
            font-size: 0.85rem;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(15, 43, 61, 0.2);
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: var(--secondary);
            color: var(--primary-dark);
        }
        
        .btn-secondary:hover {
            background: var(--secondary-dark);
            transform: translateY(-2px);
        }
        
        /* ========== HERO SECTION ========== */
        .hero {
            min-height: 90vh;
            display: flex;
            align-items: center;
            padding-top: 80px;
            position: relative;
            background: linear-gradient(135deg, #F8F6F2 0%, #F0EDE6 100%);
        }
        
        .hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }
        
        .hero-text h1 {
            font-size: 3.2rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }
        
        .hero-text h1 span {
            color: var(--secondary);
        }
        
        .hero-text p {
            font-size: 1rem;
            color: var(--gray-600);
            line-height: 1.7;
            margin-bottom: 2rem;
        }
        
        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .stat {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--secondary);
            font-family: 'Playfair Display', serif;
        }
        
        .stat-label {
            color: var(--gray-600);
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .hero-image {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .hero-logo {
            width: 350px;
            height: 350px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 30px 50px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        
        .hero-logo i {
            font-size: 120px;
            color: var(--secondary);
        }
        
        .hero-logo::before {
            content: '';
            position: absolute;
            top: -15px;
            left: -15px;
            right: -15px;
            bottom: -15px;
            border: 2px dashed var(--secondary);
            border-radius: 50%;
            opacity: 0.3;
        }
        
        .floating-card {
            position: absolute;
            background: white;
            padding: 0.8rem 1.2rem;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            animation: float 3s ease-in-out infinite;
        }
        
        .floating-card-1 {
            top: 20px;
            right: 20px;
            animation-delay: 0s;
        }
        
        .floating-card-2 {
            bottom: 60px;
            left: 0px;
            animation-delay: 1s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        /* ========== SECTIONS ========== */
        .section {
            padding: 5rem 0;
        }
        
        .section-light {
            background: var(--gray-50);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-title h2 {
            font-size: 2.2rem;
            color: var(--primary);
            margin-bottom: 1rem;
            font-weight: 700;
        }
        
        .section-title p {
            color: var(--gray-600);
            font-size: 1rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .section-title .title-decoration {
            width: 60px;
            height: 3px;
            background: var(--secondary);
            margin: 1rem auto 0;
        }
        
        /* ========== CARDS ========== */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .feature-card {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            transition: all 0.3s ease;
            text-align: center;
            border: 1px solid var(--gray-200);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.02);
        }
        
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.08);
            border-color: var(--secondary);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--secondary);
            font-size: 1.8rem;
        }
        
        .feature-card h3 {
            font-size: 1.2rem;
            margin-bottom: 0.8rem;
            color: var(--primary);
            font-family: 'Playfair Display', serif;
        }
        
        .feature-card p {
            color: var(--gray-600);
            line-height: 1.6;
            font-size: 0.85rem;
        }
        
        /* ========== HOW IT WORKS ========== */
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .step-card {
            text-align: center;
            padding: 2rem;
        }
        
        .step-number {
            width: 60px;
            height: 60px;
            background: var(--primary);
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            font-family: 'Playfair Display', serif;
        }
        
        .step-card h3 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }
        
        .step-card p {
            color: var(--gray-600);
            font-size: 0.85rem;
            line-height: 1.6;
        }
        
        /* ========== CTA ========== */
        .cta {
            padding: 5rem 0;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            text-align: center;
            position: relative;
        }
        
        .cta::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0 0 L100 100 L0 100 Z" fill="%23ffffff" opacity="0.03"/></svg>');
            background-size: cover;
        }
        
        .cta h2 {
            font-size: 2.2rem;
            color: white;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .cta p {
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 2rem;
            font-size: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .cta .btn-secondary {
            background: var(--secondary);
            color: var(--primary-dark);
        }
        
        .cta .btn-outline-light {
            background: transparent;
            border: 2px solid white;
            color: white;
        }
        
        .cta .btn-outline-light:hover {
            background: white;
            color: var(--primary);
        }
        
        /* ========== FOOTER ========== */
        .footer {
            background: var(--gray-900);
            color: var(--gray-400);
            padding: 3rem 0 1.5rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .footer-section h4 {
            margin-bottom: 1rem;
            color: var(--secondary);
            font-size: 1rem;
        }
        
        .footer-section p, .footer-section a {
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.8;
            text-decoration: none;
            font-size: 0.85rem;
        }
        
        .footer-section a:hover {
            color: var(--secondary);
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .social-links a {
            width: 35px;
            height: 35px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .social-links a:hover {
            background: var(--secondary);
            transform: translateY(-3px);
            color: var(--primary-dark);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.75rem;
        }
        
        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 2rem;
            }
            .hero-text h1 {
                font-size: 2rem;
            }
            .hero-stats {
                justify-content: center;
            }
            .nav-links {
                display: none;
            }
            .hero-logo {
                width: 250px;
                height: 250px;
                margin: 0 auto;
            }
            .hero-logo i {
                font-size: 80px;
            }
            .floating-card-1, .floating-card-2 {
                display: none;
            }
            .section {
                padding: 3rem 0;
            }
            .section-title h2 {
                font-size: 1.6rem;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 0 1rem;
            }
        }
        
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--primary);
            font-size: 1.3rem;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar" id="navbar">
    <div class="container">
        <div class="nav-content">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="logo-text">
                    <h1>NDG</h1>
                    <p>NOTRE-DAME DE GRÂCE</p>
                </div>
            </div>
            <div class="nav-links">
                <a href="#accueil">Accueil</a>
                <a href="#services">Services</a>
                <a href="#fonctionnalites">Fonctionnalités</a>
              
                
                <a href="{{ route('login') }}" class="btn btn-outline">
                    <i class="fas fa-sign-in-alt"></i> Connexion
                </a>
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Inscription
                </a>
            </div>
            <button class="mobile-menu-btn" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero" id="accueil">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text" data-aos="fade-right">
                <h1>Simplifiez les paiements scolaires avec <span>Mobile Money</span></h1>
                <p>Collège Notre-Dame de Grâce - Lubumbashi, RDC. Une solution moderne et sécurisée pour gérer tous vos frais scolaires depuis votre téléphone.</p>
                <div class="hero-stats">
                    <div class="stat">
                        <div class="stat-number">500+</div>
                        <div class="stat-label">Élèves</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">15+</div>
                        <div class="stat-label">Classes</div>
                    </div>
                    <div class="stat">
                        <div class="stat-number">4</div>
                        <div class="stat-label">Opérateurs</div>
                    </div>
                </div>
                <div style="margin-top: 2rem;">
                    <a href="{{ route('register') }}" class="btn btn-secondary">
                        <i class="fas fa-user-plus"></i> Créer un compte
                    </a>
                </div>
            </div>
            <div class="hero-image" data-aos="fade-left">
                <div class="hero-logo">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="floating-card floating-card-1">
                    <i class="fas fa-mobile-alt" style="color: var(--secondary); font-size: 1.3rem;"></i>
                    <div>
                        <strong>Mobile Money</strong><br>
                        <small>100% sécurisé</small>
                    </div>
                </div>
                <div class="floating-card floating-card-2">
                    <i class="fas fa-receipt" style="color: var(--secondary); font-size: 1.3rem;"></i>
                    <div>
                        <strong>Reçus</strong><br>
                        <small>Automatiques</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section" id="fonctionnalites">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Une solution complète</h2>
            <div class="title-decoration"></div>
            <p>Tout ce dont vous avez besoin pour gérer les paiements scolaires</p>
        </div>
        <div class="features-grid">
            <div class="feature-card" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
                <h3>Mobile Money</h3>
                <p>Airtel Money, Orange Money, Vodacom M-PesaPayez en CDF ou USD.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Sécurité totale</h3>
                <p>Transactions chiffrées et traçabilité complète de chaque opération.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-icon"><i class="fas fa-file-pdf"></i></div>
                <h3>Reçus PDF</h3>
                <p>Génération instantanée de reçus téléchargeables et envoyés par email.</p>
            </div>
            <div class="feature-card" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <h3>Suivi en temps réel</h3>
                <p>Tableau de bord interactif avec statistiques et graphiques.</p>
            </div>
            
            <div class="feature-card" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-icon"><i class="fas fa-hand-holding-usd"></i></div>
                <h3>Multi-devises</h3>
                <p>Paiement en CDF ou USD au choix.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="section-light" id="services">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Comment ça marche</h2>
            <div class="title-decoration"></div>
            <p>Un processus simple en trois étapes</p>
        </div>
        <div class="steps-grid">
            <div class="step-card" data-aos="fade-up" data-aos-delay="100">
                <div class="step-number">1</div>
                <h3>Inscription</h3>
                <p>Créez votre compte en quelques clics en tant que parent ou élève.</p>
            </div>
            <div class="step-card" data-aos="fade-up" data-aos-delay="200">
                <div class="step-number">2</div>
                <h3>Paiement</h3>
                <p>Sélectionnez l'élève, le montant et confirmez via Mobile Money.</p>
            </div>
            <div class="step-card" data-aos="fade-up" data-aos-delay="300">
                <div class="step-number">3</div>
                <h3>Validation</h3>
                <p>Recevez votre reçu par email et suivez vos paiements en temps réel.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta">
    <div class="container" data-aos="fade-up">
        <h2>Prêt à simplifier vos paiements ?</h2>
        <p>Rejoignez plus de 1200 élèves qui utilisent déjà notre solution au Collège Notre-Dame de Grâce.</p>
        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('register') }}" class="btn btn-secondary">
                <i class="fas fa-user-plus"></i> Créer un compte
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-light">
                <i class="fas fa-sign-in-alt"></i> Se connecter
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer" id="contact">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Collège NDG</h4>
                <p><i class="fas fa-map-marker-alt"></i> Lubumbashi, Haut-Katanga, RDC</p>
                <p><i class="fas fa-phone"></i> +243 </p>
                <p><i class="fas fa-envelope"></i> nom@gmail.com</p>
            </div>
            <div class="footer-section">
                <h4>Horaires</h4>
                <p>Lundi-Vendredi: 8h - 16h30</p>
                <p>Samedi: 8h - 12h</p>
                <p>Dimanche: Fermé</p>
            </div>
            <div class="footer-section">
                <h4>Liens rapides</h4>
                <p><a href="#accueil">Accueil</a></p>
                <p><a href="#services">Services</a></p>
                <p><a href="#fonctionnalites">Fonctionnalités</a></p>
                <p><a href="{{ route('login') }}">Connexion</a></p>
                <p><a href="{{ route('register') }}">Inscription</a></p>
            </div>
            <div class="footer-section">
                <h4>Collège Notre-Dame de Grâce</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                  
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Collège Notre-Dame de Grâce - Lubumbashi, RDC. Tous droits réservés.</p>
        </div>
    </div>
</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true });
    
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) navbar.classList.add('scrolled');
        else navbar.classList.remove('scrolled');
    });
    
    function toggleMenu() {
        const menu = document.getElementById('mobileMenu');
        if (menu) {
            menu.style.display = menu.style.display === 'none' || menu.style.display === '' ? 'flex' : 'none';
        }
    }
    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) target.scrollIntoView({ behavior: 'smooth' });
        });
    });
    
    // Mobile menu dynamic creation
    if (!document.getElementById('mobileMenu')) {
        const mobileDiv = document.createElement('div');
        mobileDiv.id = 'mobileMenu';
        mobileDiv.style.display = 'none';
        mobileDiv.style.flexDirection = 'column';
        mobileDiv.style.position = 'fixed';
        mobileDiv.style.top = '70px';
        mobileDiv.style.left = '0';
        mobileDiv.style.right = '0';
        mobileDiv.style.background = 'white';
        mobileDiv.style.padding = '1.5rem';
        mobileDiv.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
        mobileDiv.style.zIndex = '999';
        mobileDiv.style.gap = '1rem';
        mobileDiv.innerHTML = `
            <a href="#accueil" style="color: #424242; text-decoration: none; padding: 0.5rem;">Accueil</a>
            <a href="#services" style="color: #424242; text-decoration: none; padding: 0.5rem;">Services</a>
            <a href="#fonctionnalites" style="color: #424242; text-decoration: none; padding: 0.5rem;">Fonctionnalités</a>
            <a href="#contact" style="color: #424242; text-decoration: none; padding: 0.5rem;">Contact</a>
            <hr style="margin: 0.5rem 0;">
            <a href="{{ route('login') }}" class="btn btn-outline" style="text-align: center;">Connexion</a>
            <a href="{{ route('register') }}" class="btn btn-primary" style="text-align: center;">Inscription</a>
        `;
        document.body.appendChild(mobileDiv);
    }
    
    const mobileMenu = document.getElementById('mobileMenu');
    window.toggleMenu = function() {
        if (mobileMenu) {
            mobileMenu.style.display = mobileMenu.style.display === 'none' || mobileMenu.style.display === '' ? 'flex' : 'none';
        }
    }
</script>
</body>
</html>