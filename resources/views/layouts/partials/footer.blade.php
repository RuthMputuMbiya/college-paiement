{{-- resources/views/partials/footer.blade.php --}}
<footer class="footer">
    <div class="footer-container">
        <div class="footer-grid">
            <!-- About / Logo -->
            <div class="footer-col">
                <div class="footer-logo">
                    <div class="logo-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="logo-text">
                        <span>Collège <span class="gradient-text">NDG</span></span>
                        <small>Notre-Dame de Grâce</small>
                    </div>
                </div>
                <p class="footer-description">
                    Un établissement d'excellence au service de l'éducation, offrant des solutions innovantes pour la gestion scolaire.
                </p>
                <div class="social-links">
                    <a href="#" class="social-link" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="social-link" aria-label="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
            
            <!-- Liens rapides -->
            <div class="footer-col">
                <h3 class="footer-title">
                    <i class="fas fa-link"></i>
                    <span>Liens rapides</span>
                </h3>
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-chevron-right"></i> À propos</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Admission</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Contact</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Support</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> FAQ</a></li>
                </ul>
            </div>
            
            <!-- Contact -->
            <div class="footer-col">
                <h3 class="footer-title">
                    <i class="fas fa-address-card"></i>
                    <span>Contact</span>
                </h3>
                <ul class="contact-info">
                    <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <strong>Adresse</strong>
                            <span>Lubumbashi, Haut-Katanga<br>République Démocratique du Congo</span>
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-phone-alt"></i>
                        <div>
                            <strong>Téléphone</strong>
                            <span>+243 123 456 789</span>
                        </div>
                    </li>
                    <li>
                        <i class="fas fa-envelope"></i>
                        <div>
                            <strong>Email</strong>
                            <span>info@college-ndg.cd</span>
                        </div>
                    </li>
                </ul>
            </div>
            
            <!-- Horaires & Newsletter -->
            <div class="footer-col">
                <h3 class="footer-title">
                    <i class="fas fa-clock"></i>
                    <span>Horaires</span>
                </h3>
                <ul class="hours-list">
                    <li>
                        <span>Lundi - Vendredi</span>
                        <span class="hours-time">8h00 - 17h00</span>
                    </li>
                    <li>
                        <span>Samedi</span>
                        <span class="hours-time">9h00 - 13h00</span>
                    </li>
                    <li>
                        <span>Dimanche</span>
                        <span class="hours-time closed">Fermé</span>
                    </li>
                </ul>
                
                <div class="newsletter">
                    <h4 class="newsletter-title">
                        <i class="fas fa-paper-plane"></i>
                        <span>Newsletter</span>
                    </h4>
                    <div class="newsletter-form">
                        <input type="email" placeholder="Votre email" class="newsletter-input">
                        <button class="newsletter-btn">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                    <p class="newsletter-note">Recevez nos actualités et offres</p>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="copyright">
                <p>&copy; {{ date('Y') }} Collège Notre-Dame de Grâce - Tous droits réservés.</p>
                <p class="security-badge">
                    <i class="fas fa-shield-alt"></i> Système sécurisé de paiement scolaire par Mobile Money
                </p>
            </div>
            <div class="legal-links">
                <a href="#">Conditions d'utilisation</a>
                <span class="separator">|</span>
                <a href="#">Politique de confidentialité</a>
                <span class="separator">|</span>
                <a href="#">Mentions légales</a>
            </div>
        </div>
    </div>
</footer>

<style>
    /* ============================================
       FOOTER MODERNE - COINS CARRÉS
       DESIGN PROFESSIONNEL - COULEURS MODERNES
    ============================================ */
    
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --primary-light: #818cf8;
        --secondary: #06b6d4;
        --secondary-dark: #0891b2;
        --accent: #f43f5e;
        --success: #10b981;
        --dark: #0f172a;
        --dark-light: #1e293b;
        --gray: #64748b;
        --gray-light: #f8fafc;
        --white: #ffffff;
        --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #06b6d4 100%);
        --gradient-dark: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-glow: 0 0 15px rgba(99, 102, 241, 0.3);
        --transition: all 0.3s ease;
    }

    /* Coins carrés */
    .footer, .footer-logo, .logo-icon, .social-link, .newsletter-input, 
    .newsletter-btn, .footer-links a, .contact-info li, .hours-list li {
        border-radius: 0px !important;
    }

    .footer {
        background: var(--gradient-dark);
        color: var(--white);
        position: relative;
        overflow: hidden;
        border-top: none;
        margin-top: 4rem;
    }

    /* Animation d'arrière-plan */
    .footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><circle cx="20" cy="20" r="15" fill="%236366f1" opacity="0.03"/><circle cx="80" cy="80" r="25" fill="%238b5cf6" opacity="0.03"/><circle cx="90" cy="30" r="10" fill="%2306b6d4" opacity="0.03"/></svg>');
        background-size: cover;
        pointer-events: none;
    }

    .footer-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 3rem 1.5rem 1.5rem;
        position: relative;
        z-index: 1;
    }

    /* Footer Grid */
    .footer-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        margin-bottom: 2rem;
    }

    /* Logo Section */
    .footer-logo {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .logo-icon {
        width: 48px;
        height: 48px;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-glow);
    }

    .logo-icon i {
        font-size: 1.5rem;
        color: var(--white);
    }

    .logo-text {
        display: flex;
        flex-direction: column;
    }

    .logo-text span {
        font-weight: 800;
        font-size: 1.1rem;
        letter-spacing: -0.5px;
    }

    .gradient-text {
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    .logo-text small {
        font-size: 0.65rem;
        color: rgba(255, 255, 255, 0.5);
    }

    .footer-description {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.875rem;
        line-height: 1.6;
        margin-bottom: 1.25rem;
    }

    /* Social Links */
    .social-links {
        display: flex;
        gap: 0.75rem;
    }

    .social-link {
        width: 38px;
        height: 38px;
        background: rgba(255, 255, 255, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255, 255, 255, 0.6);
        transition: var(--transition);
        font-size: 1rem;
    }

    .social-link:hover {
        background: var(--gradient-primary);
        color: var(--white);
        transform: translateY(-3px);
        box-shadow: var(--shadow-glow);
    }

    /* Footer Titles */
    .footer-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid rgba(99, 102, 241, 0.3);
    }

    .footer-title i {
        color: var(--primary-light);
        font-size: 0.9rem;
    }

    /* Footer Links */
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 0.75rem;
    }

    .footer-links a {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: rgba(255, 255, 255, 0.6);
        text-decoration: none;
        font-size: 0.875rem;
        transition: var(--transition);
    }

    .footer-links a i {
        font-size: 0.7rem;
        transition: var(--transition);
    }

    .footer-links a:hover {
        color: var(--primary-light);
        transform: translateX(5px);
    }

    .footer-links a:hover i {
        transform: translateX(3px);
        color: var(--primary-light);
    }

    /* Contact Info */
    .contact-info {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .contact-info li {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1rem;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.875rem;
    }

    .contact-info li i {
        width: 20px;
        color: var(--primary-light);
        margin-top: 0.2rem;
    }

    .contact-info li div {
        display: flex;
        flex-direction: column;
    }

    .contact-info li strong {
        font-weight: 600;
        color: var(--white);
        font-size: 0.75rem;
        margin-bottom: 0.25rem;
    }

    /* Hours List */
    .hours-list {
        list-style: none;
        padding: 0;
        margin: 0 0 1.5rem 0;
    }

    .hours-list li {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.875rem;
        border-bottom: 1px dashed rgba(255, 255, 255, 0.1);
    }

    .hours-list li:last-child {
        border-bottom: none;
    }

    .hours-time {
        color: var(--white);
        font-weight: 500;
    }

    .hours-time.closed {
        color: var(--accent);
    }

    /* Newsletter */
    .newsletter {
        margin-top: 1rem;
    }

    .newsletter-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: var(--white);
    }

    .newsletter-title i {
        color: var(--primary-light);
    }

    .newsletter-form {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .newsletter-input {
        flex: 1;
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: var(--white);
        font-size: 0.875rem;
        transition: var(--transition);
    }

    .newsletter-input:focus {
        outline: none;
        border-color: var(--primary);
        background: rgba(255, 255, 255, 0.12);
    }

    .newsletter-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .newsletter-btn {
        padding: 0.75rem 1rem;
        background: var(--gradient-primary);
        border: none;
        color: var(--white);
        cursor: pointer;
        transition: var(--transition);
    }

    .newsletter-btn:hover {
        transform: translateX(3px);
        box-shadow: var(--shadow-glow);
    }

    .newsletter-note {
        font-size: 0.65rem;
        color: rgba(255, 255, 255, 0.4);
    }

    /* Footer Bottom */
    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding-top: 1.5rem;
        margin-top: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .copyright {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .copyright p {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.75rem;
        margin: 0;
    }

    .security-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .security-badge i {
        color: var(--success);
        font-size: 0.7rem;
    }

    .legal-links {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .legal-links a {
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        font-size: 0.7rem;
        transition: var(--transition);
    }

    .legal-links a:hover {
        color: var(--primary-light);
    }

    .legal-links .separator {
        color: rgba(255, 255, 255, 0.2);
        font-size: 0.7rem;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .footer-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }
    }

    @media (max-width: 768px) {
        .footer-container {
            padding: 2rem 1rem 1rem;
        }
        
        .footer-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .footer-bottom {
            flex-direction: column;
            text-align: center;
        }
        
        .legal-links {
            justify-content: center;
        }
        
        .copyright {
            align-items: center;
        }
    }

    @media (max-width: 480px) {
        .footer-logo {
            justify-content: center;
        }
        
        .footer-description {
            text-align: center;
        }
        
        .social-links {
            justify-content: center;
        }
        
        .footer-title {
            justify-content: center;
        }
        
        .footer-links li a {
            justify-content: center;
        }
        
        .contact-info li {
            justify-content: center;
        }
        
        .hours-list li {
            justify-content: center;
            gap: 1rem;
        }
        
        .newsletter {
            text-align: center;
        }
    }
</style>