<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Collège Notre-Dame de Grâce - Système de paiement scolaire sécurisé par Mobile Money à Lubumbashi, RDC">
    <meta name="keywords" content="paiement scolaire, Mobile Money, Lubumbashi, RDC, école, collège">
    <meta name="author" content="Collège Notre-Dame de Grâce">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Collège NDG') }} - Paiements scolaires simplifiés à Lubumbashi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        /* ============================================
           VARIABLES & RESET - COINS CARRÉS
           Couleurs modernes et attrayantes pour les élèves
        ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        :root {
            /* Couleurs principales - Dégradé moderne violet/bleu qui plaît aux élèves */
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #818cf8;
            --secondary: #06b6d4;
            --secondary-dark: #0891b2;
            --accent: #f43f5e;
            --accent-light: #fb7185;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            --dark-light: #334155;
            --gray: #64748b;
            --gray-light: #f8fafc;
            --white: #ffffff;
            
            /* Dégradés modernes */
            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #06b6d4 100%);
            --gradient-hero: linear-gradient(135deg, #6366f1 0%, #5759a2 50%, #4338ca 100%);
            --gradient-card: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            
            /* Ombres */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            --shadow-glow: 0 0 20px rgba(99, 102, 241, 0.3);
            
            /* Transitions */
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-light);
            color: var(--dark);
            line-height: 1.5;
            overflow-x: hidden;
        }

        /* Coins carrés - AUCUN BORDER RADIUS */
        .btn,
        .card,
        .navbar,
        .hero,
        .section,
        input,
        select,
        textarea,
        .modal-content,
        .badge,
        .step-item,
        .testimonial-card,
        .footer,
        .social-link,
        .newsletter-input,
        .newsletter-btn,
        .card-icon,
        .step-icon,
        .step-number,
        .testimonial-avatar,
        .contact-info-icon,
        .partner-logo {
            border-radius: 0px !important;
        }

        /* ============================================
           TYPOGRAPHIE MODERNE
        ============================================ */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 0.5rem;
        }

        .display-1 {
            font-size: 4rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .display-2 {
            font-size: 3rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        /* ============================================
           BOUTONS MODERNES
        ============================================ */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: var(--transition);
            cursor: pointer;
            border: none;
            text-decoration: none;
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
            border: none;
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

        .btn-outline-light {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.8);
            color: var(--white);
        }

        .btn-outline-light:hover {
            background: var(--white);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .btn-outline-primary {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: var(--gradient-primary);
            color: var(--white);
            border-color: transparent;
            transform: translateY(-2px);
        }

        .btn-lg {
            padding: 1rem 2rem;
            font-size: 1rem;
        }

        /* ============================================
           NAVIGATION MODERNE
        ============================================ */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1.25rem 0;
            transition: var(--transition);
            background: transparent;
        }

        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow);
            padding: 0.75rem 0;
        }

        .navbar-scrolled .nav-link {
            color: var(--dark);
        }

        .navbar-scrolled .logo-text {
            color: var(--primary);
        }

        .navbar-scrolled .logo span {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .nav-link {
            color: var(--white);
            font-weight: 500;
            transition: var(--transition);
            padding: 0.5rem 1rem;
            text-decoration: none;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--gradient-primary);
            transition: var(--transition);
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .navbar-scrolled .nav-link:hover {
            color: var(--primary);
        }

        .nav-link:hover {
            color: rgba(255, 255, 255, 0.9);
        }

        /* ============================================
           HERO SECTION - ATTRACTIVE
        ============================================ */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: var(--gradient-hero);
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0 0 L100 100 L0 100 Z" fill="%23ffffff" opacity="0.03"/></svg>');
            background-size: cover;
        }

        .hero::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at 30% 50%, rgba(139, 92, 246, 0.15) 0%, transparent 60%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: var(--white);
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.25rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            font-weight: 500;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-title span {
            background: linear-gradient(135deg, #a78bfa 0%, #f43f5e 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 3rem;
            margin-top: 3rem;
        }

        .stat-item {
            text-align: center;
            background: rgba(255, 255, 255, 0.05);
            padding: 1rem 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
            background: linear-gradient(135deg, #fff 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .stat-label {
            font-size: 0.8rem;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* ============================================
           SECTIONS MODERNES
        ============================================ */
        .section {
            padding: 5rem 0;
        }

        .section-bg-light {
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
        }

        .section-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 3rem;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 1rem;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            color: var(--primary);
            font-weight: 600;
            font-size: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(99, 102, 241, 0.2);
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1rem;
            color: var(--gray);
            line-height: 1.6;
        }

        /* ============================================
           CARTES MODERNES AVEC BORDURES COLORÉES
        ============================================ */
        .card {
            background: var(--gradient-card);
            padding: 2rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid rgba(99, 102, 241, 0.1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: var(--transition);
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-xl);
            border-color: rgba(99, 102, 241, 0.2);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: var(--transition);
        }

        .card-icon i {
            font-size: 1.75rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .card:hover .card-icon {
            background: var(--gradient-primary);
        }

        .card:hover .card-icon i {
            color: var(--white);
            background: none;
            -webkit-background-clip: unset;
            background-clip: unset;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--dark);
        }

        .card-text {
            color: var(--gray);
            line-height: 1.6;
            font-size: 0.9rem;
        }

        /* ============================================
           ÉTAPES MODERNES
        ============================================ */
        .step-item {
            background: var(--white);
            padding: 2rem;
            box-shadow: var(--shadow);
            text-align: center;
            transition: var(--transition);
            border: 1px solid rgba(99, 102, 241, 0.1);
            height: 100%;
            position: relative;
        }

        .step-item:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .step-number {
            width: 50px;
            height: 50px;
            background: var(--gradient-primary);
            color: var(--white);
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .step-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            transition: var(--transition);
        }

        .step-icon i {
            font-size: 2rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .step-item:hover .step-icon {
            background: var(--gradient-primary);
        }

        .step-item:hover .step-icon i {
            color: var(--white);
            background: none;
        }

        .step-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--dark);
        }

        .step-text {
            color: var(--gray);
            line-height: 1.6;
            font-size: 0.875rem;
        }

        /* ============================================
           TÉMOIGNAGES MODERNES
        ============================================ */
        .testimonial-card {
            background: var(--white);
            padding: 2rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: 1px solid rgba(99, 102, 241, 0.1);
            height: 100%;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--secondary);
        }

        .testimonial-quote {
            font-size: 2rem;
            margin-bottom: 1rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            opacity: 0.5;
        }

        .testimonial-text {
            color: var(--dark);
            line-height: 1.7;
            margin-bottom: 1.5rem;
            font-style: italic;
            font-size: 0.9rem;
        }

        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .testimonial-avatar {
            width: 45px;
            height: 45px;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 600;
            font-size: 1rem;
        }

        .testimonial-name {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        .testimonial-role {
            font-size: 0.75rem;
            color: var(--gray);
        }

        /* ============================================
           CTA SECTION
        ============================================ */
        .cta-section {
            position: relative;
            padding: 5rem 0;
            background: var(--gradient-primary);
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><circle cx="50" cy="50" r="40" fill="%23ffffff" opacity="0.05"/></svg>');
            background-size: cover;
        }

        .cta-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: var(--white);
            max-width: 700px;
            margin: 0 auto;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .cta-text {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        /* ============================================
           FOOTER MODERNE
        ============================================ */
        .footer {
            background: var(--dark);
            color: var(--white);
            padding: 3rem 0 1.5rem;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            transition: var(--transition);
        }

        .footer a:hover {
            color: var(--secondary);
        }

        .footer-logo {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .footer-logo span {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .footer-text {
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }

        .footer-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
            color: var(--white);
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            font-size: 0.875rem;
        }

        .social-links {
            display: flex;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .social-link {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .social-link:hover {
            background: var(--gradient-primary);
            transform: translateY(-2px);
        }

        .newsletter-form {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .newsletter-input {
            flex: 1;
            padding: 0.625rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.05);
            color: var(--white);
            font-size: 0.875rem;
        }

        .newsletter-input::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .newsletter-btn {
            padding: 0.625rem 1.25rem;
            background: var(--gradient-primary);
            border: none;
            color: var(--white);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .newsletter-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-glow);
        }

        .copyright {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.75rem;
        }

        /* ============================================
           PARTENAIRES
        ============================================ */
        .partners {
            padding: 2rem 0;
            background: var(--white);
        }

        .partners-title {
            text-align: center;
            color: var(--gray);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 2rem;
        }

        .partners-grid {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 3rem;
            flex-wrap: wrap;
        }

        .partner-logo {
            max-height: 35px;
            opacity: 0.5;
            transition: var(--transition);
            filter: grayscale(100%);
        }

        .partner-logo:hover {
            opacity: 1;
            filter: grayscale(0%);
        }

        /* ============================================
           CONTACT FORM MODERNE
        ============================================ */
        .contact-form {
            background: var(--white);
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(99, 102, 241, 0.1);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e2e8f0;
            transition: var(--transition);
            font-size: 0.875rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .contact-info-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .contact-info-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(139, 92, 246, 0.1) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-info-icon i {
            font-size: 1.25rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .contact-info-content h4 {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--dark);
        }

        .contact-info-content p {
            font-size: 0.875rem;
            color: var(--gray);
            margin-bottom: 0;
        }

        /* ============================================
           GRID SYSTEM
        ============================================ */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        /* ============================================
           RESPONSIVE
        ============================================ */
        @media (max-width: 992px) {
            .grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .hero-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .grid-2, .grid-3, .grid-4 {
                grid-template-columns: 1fr;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-stats {
                flex-direction: column;
                gap: 1rem;
            }
            
            .section {
                padding: 3rem 0;
            }
            
            .section-title {
                font-size: 1.5rem;
            }
            
            .cta-title {
                font-size: 1.75rem;
            }
            
            .nav-menu, .auth-buttons {
                display: none !important;
            }
            
            .mobile-menu-btn {
                display: block !important;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 1rem;
            }
            
            .hero-title {
                font-size: 1.75rem;
            }
            
            .btn-lg {
                padding: 0.75rem 1.25rem;
                font-size: 0.875rem;
            }
        }

        /* ============================================
           MOBILE MENU
        ============================================ */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--white);
            font-size: 1.5rem;
            cursor: pointer;
        }

        .navbar-scrolled .mobile-menu-btn {
            color: var(--primary);
        }

        /* ============================================
           ANIMATIONS
        ============================================ */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        /* ============================================
           UTILITAIRES
        ============================================ */
        .text-center { text-align: center; }
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-3 { margin-top: 0.75rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-5 { margin-top: 1.25rem; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 0.75rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-5 { margin-bottom: 1.25rem; }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar" id="navbar">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <!-- Logo -->
                <a href="/" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none;">
                    <div style="width: 40px; height: 40px; background: var(--gradient-primary); display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-graduation-cap" style="color: var(--white); font-size: 1.25rem;"></i>
                    </div>
                    <span class="logo-text" style="font-size: 1.25rem; font-weight: 700; color: var(--white);">Collège<span style="background: linear-gradient(135deg, #a78bfa 0%, #f43f5e 100%); -webkit-background-clip: text; background-clip: text; color: transparent;">NDG</span></span>
                </a>

                <!-- Desktop Menu -->
                <div class="nav-menu" style="display: flex; align-items: center; gap: 1.5rem;">
                    <a href="#accueil" class="nav-link">Accueil</a>
                    <a href="#fonctionnalites" class="nav-link">Fonctionnalités</a>
                    <a href="#comment-ca-marche" class="nav-link">Comment ça marche</a>
                    <a href="#temoignages" class="nav-link">Témoignages</a>
                    <a href="#contact" class="nav-link">Contact</a>
                </div>

                <!-- Auth Buttons -->
                <div class="auth-buttons" style="display: flex; align-items: center; gap: 0.75rem;">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-light" style="padding: 0.5rem 1.25rem;">
                            <i class="fas fa-sign-in-alt"></i> Connexion
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary" style="padding: 0.5rem 1.25rem;">
                            <i class="fas fa-user-plus"></i> Inscription
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    @endguest
                </div>

                <!-- Mobile Menu Button -->
                <button class="mobile-menu-btn" onclick="toggleMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" style="display: none; background: var(--white); margin-top: 1rem; box-shadow: var(--shadow);">
                <div style="display: flex; flex-direction: column; gap: 0.5rem; padding: 1rem;">
                    <a href="#accueil" class="nav-link" style="color: var(--dark); padding: 0.75rem;">Accueil</a>
                    <a href="#fonctionnalites" class="nav-link" style="color: var(--dark); padding: 0.75rem;">Fonctionnalités</a>
                    <a href="#comment-ca-marche" class="nav-link" style="color: var(--dark); padding: 0.75rem;">Comment ça marche</a>
                    <a href="#temoignages" class="nav-link" style="color: var(--dark); padding: 0.75rem;">Témoignages</a>
                    <a href="#contact" class="nav-link" style="color: var(--dark); padding: 0.75rem;">Contact</a>
                    <div style="border-top: 1px solid #e2e8f0; margin-top: 0.5rem; padding-top: 0.5rem;">
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-primary" style="display: block; text-align: center; margin-bottom: 0.5rem;">Connexion</a>
                            <a href="{{ route('register') }}" class="btn btn-primary" style="display: block; text-align: center;">Inscription</a>
                        @else
                            <a href="{{ route('dashboard') }}" class="btn btn-primary" style="display: block; text-align: center;">Dashboard</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="accueil" class="hero">
        <div class="container">
            <div class="hero-content" data-aos="fade-up">
                <div class="hero-badge">
                    <i class="fas fa-map-marker-alt"></i> Lubumbashi, République Démocratique du Congo
                </div>
                
                <h1 class="hero-title">
                    Simplifiez les paiements<br>scolaires avec <span>Mobile Money</span>
                </h1>
                
                <p class="hero-subtitle">
                    Collège Notre-Dame de Grâce vous propose une solution moderne et sécurisée 
                    pour gérer tous vos frais scolaires depuis votre téléphone.
                </p>
                
                <div>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-rocket"></i> Commencer maintenant
                    </a>
                    <a href="#fonctionnalites" class="btn btn-outline-light btn-lg" style="margin-left: 1rem;">
                        <i class="fas fa-play-circle"></i> Voir la démo
                    </a>
                </div>

                <!-- Stats -->
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number counter" data-target="1200">0</div>
                        <div class="stat-label">Élèves</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number counter" data-target="45">0</div>
                        <div class="stat-label">Classes</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number counter" data-target="4">0</div>
                        <div class="stat-label">Opérateurs</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number counter" data-target="99">0</div>
                        <div class="stat-label">Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="partners">
        <div class="container">
            <p class="partners-title">ILS NOUS FONT CONFIANCE</p>
            <div class="partners-grid">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Airtel_logo.svg/2560px-Airtel_logo.svg.png" alt="Airtel" class="partner-logo">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/Orange_logo.svg/2560px-Orange_logo.svg.png" alt="Orange" class="partner-logo">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/8e/Vodacom_Logo.svg/2560px-Vodacom_Logo.svg.png" alt="Vodacom" class="partner-logo">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Africell_logo.svg/2560px-Africell_logo.svg.png" alt="Africell" class="partner-logo">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="fonctionnalites" class="section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-badge"><i class="fas fa-star"></i> FONCTIONNALITÉS</div>
                <h2 class="section-title">Tout ce dont vous avez besoin</h2>
                <p class="section-subtitle">Une solution complète pour gérer les paiements scolaires en toute simplicité</p>
            </div>

            <div class="grid-3">
                <div class="card" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-icon"><i class="fas fa-mobile-alt"></i></div>
                    <h3 class="card-title">Paiement Mobile Money</h3>
                    <p class="card-text">Airtel Money, Orange Money, Vodacom M-Pesa, Africell Money. Payez en CDF ou USD depuis votre téléphone.</p>
                </div>

                <div class="card" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3 class="card-title">Sécurité Maximale</h3>
                    <p class="card-text">Transactions chiffrées et traçabilité complète de chaque opération pour une tranquillité d'esprit totale.</p>
                </div>

                <div class="card" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-icon"><i class="fas fa-file-pdf"></i></div>
                    <h3 class="card-title">Reçus Automatiques</h3>
                    <p class="card-text">Génération instantanée de reçus PDF téléchargeables et envoyés par email/SMS à chaque transaction.</p>
                </div>

                <div class="card" data-aos="fade-up" data-aos-delay="400">
                    <div class="card-icon"><i class="fas fa-chart-line"></i></div>
                    <h3 class="card-title">Suivi en Temps Réel</h3>
                    <p class="card-text">Tableau de bord interactif pour suivre tous les paiements avec statistiques et graphiques.</p>
                </div>

                <div class="card" data-aos="fade-up" data-aos-delay="500">
                    <div class="card-icon"><i class="fas fa-bell"></i></div>
                    <h3 class="card-title">Notifications Instantanées</h3>
                    <p class="card-text">Alertes SMS et email pour chaque transaction, rappels de paiement et communications importantes.</p>
                </div>

                <div class="card" data-aos="fade-up" data-aos-delay="600">
                    <div class="card-icon"><i class="fas fa-hand-holding-usd"></i></div>
                    <h3 class="card-title">Multi-devises</h3>
                    <p class="card-text">Paiement en Francs Congolais (CDF) ou Dollars Américains (USD) au choix.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="comment-ca-marche" class="section section-bg-light">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-badge"><i class="fas fa-magic"></i> COMMENT ÇA MARCHE</div>
                <h2 class="section-title">Trois étapes simples</h2>
                <p class="section-subtitle">Un processus fluide et intuitif pour tous les utilisateurs</p>
            </div>

            <div class="grid-3">
                <div class="step-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-icon"><i class="fas fa-user-plus"></i></div>
                    <div class="step-number">1</div>
                    <h3 class="step-title">Inscrivez-vous</h3>
                    <p class="step-text">Créez votre compte en quelques clics en tant que parent ou élève.</p>
                </div>

                <div class="step-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="step-icon"><i class="fas fa-mobile-alt"></i></div>
                    <div class="step-number">2</div>
                    <h3 class="step-title">Payez par Mobile Money</h3>
                    <p class="step-text">Sélectionnez l'élève, le montant et confirmez via votre téléphone.</p>
                </div>

                <div class="step-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="step-number">3</div>
                    <h3 class="step-title">C'est fait !</h3>
                    <p class="step-text">Recevez votre reçu par email et suivez vos paiements en temps réel.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="temoignages" class="section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <div class="section-badge"><i class="fas fa-heart"></i> TÉMOIGNAGES</div>
                <h2 class="section-title">Ce qu'ils disent de nous</h2>
                <p class="section-subtitle">Découvrez les retours de notre communauté</p>
            </div>

            <div class="grid-3">
                <div class="testimonial-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-quote"><i class="fas fa-quote-left"></i></div>
                    <p class="testimonial-text">"Fini les files d'attente ! Je paye la scolarité de mes trois enfants depuis mon téléphone en 2 minutes. Un gain de temps incroyable !"</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">MK</div>
                        <div>
                            <div class="testimonial-name">Marie Kabasele</div>
                            <div class="testimonial-role">Parent d'élève</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-quote"><i class="fas fa-quote-left"></i></div>
                    <p class="testimonial-text">"La traçabilité est parfaite ! Je génère des rapports en un clic et les litiges sont traités rapidement. Un outil indispensable."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">PM</div>
                        <div>
                            <div class="testimonial-name">Paul Mwamba</div>
                            <div class="testimonial-role">Comptable</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-quote"><i class="fas fa-quote-left"></i></div>
                    <p class="testimonial-text">"Notre établissement a gagné en efficacité et en sécurité. Les parents adorent la simplicité du système."</p>
                    <div class="testimonial-author">
                        <div class="testimonial-avatar">JT</div>
                        <div>
                            <div class="testimonial-name">Jean-Luc Tshibangu</div>
                            <div class="testimonial-role">Directeur</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2 class="cta-title">Prêt à simplifier vos paiements ?</h2>
                <p class="cta-text">
                    Rejoignez plus de 1200 élèves et 45 classes qui utilisent déjà notre solution 
                    au Collège Notre-Dame de Grâce à Lubumbashi.
                </p>
                <div>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus"></i> Créer un compte gratuit
                    </a>
                    <a href="#contact" class="btn btn-outline-light btn-lg" style="margin-left: 1rem;">
                        <i class="fas fa-headset"></i> Contacter le support
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="grid-4">
                <div>
                    <a href="/" class="footer-logo">Collège<span>NDG</span></a>
                    <p class="footer-text">Le Collège Notre-Dame de Grâce à Lubumbashi vous offre une solution moderne et sécurisée pour la gestion des paiements scolaires.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <div>
                    <h3 class="footer-title">Liens rapides</h3>
                    <ul class="footer-links">
                        <li><a href="#accueil">Accueil</a></li>
                        <li><a href="#fonctionnalites">Fonctionnalités</a></li>
                        <li><a href="#comment-ca-marche">Comment ça marche</a></li>
                        <li><a href="#temoignages">Témoignages</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="footer-title">Informations légales</h3>
                    <ul class="footer-links">
                        <li><a href="#">Conditions d'utilisation</a></li>
                        <li><a href="#">Politique de confidentialité</a></li>
                        <li><a href="#">Mentions légales</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="footer-title">Newsletter</h3>
                    <p class="footer-text">Recevez nos actualités et offres exclusives</p>
                    <form action="#" method="POST" class="newsletter-form">
                        @csrf
                        <input type="email" placeholder="Votre email" class="newsletter-input">
                        <button type="submit" class="newsletter-btn"><i class="fas fa-paper-plane"></i></button>
                    </form>
                </div>
            </div>

            <div class="copyright">
                <p>&copy; {{ date('Y') }} Collège Notre-Dame de Grâce - Lubumbashi, RDC. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({ duration: 800, once: true });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });

        // Mobile menu toggle
        function toggleMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.style.display = menu.style.display === 'none' || menu.style.display === '' ? 'block' : 'none';
        }

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    const menu = document.getElementById('mobileMenu');
                    if (menu) menu.style.display = 'none';
                }
            });
        });

        // Counter animation
        const counters = document.querySelectorAll('.counter');
        const speed = 200;

        const animateCounter = (counter) => {
            const target = +counter.getAttribute('data-target');
            const increment = target / speed;
            let current = 0;
            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.innerText = Math.ceil(current).toLocaleString();
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.innerText = target.toLocaleString();
                }
            };
            updateCounter();
        };

        const observerOptions = { threshold: 0.5 };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.querySelectorAll('.counter').forEach(counter => animateCounter(counter));
                }
            });
        }, observerOptions);

        const heroSection = document.querySelector('#accueil');
        if (heroSection) observer.observe(heroSection);

        // Responsive
        function checkScreenSize() {
            if (window.innerWidth <= 768) {
                const btn = document.querySelector('.mobile-menu-btn');
                if (btn) btn.style.display = 'block';
            } else {
                const btn = document.querySelector('.mobile-menu-btn');
                if (btn) btn.style.display = 'none';
                const menu = document.getElementById('mobileMenu');
                if (menu) menu.style.display = 'none';
            }
        }
        window.addEventListener('resize', checkScreenSize);
        checkScreenSize();
    </script>
</body>
</html>