<?= view('navbar') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>OnlyFlights - Next-Gen Aviation & Flight Management</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        /* Hero Section Styling */
        .hero-section {
            position: relative;
            padding: 85px 30px;
            text-align: center;
            background: linear-gradient(180deg, rgba(14, 16, 26, 0.75) 0%, rgba(9, 10, 16, 0.92) 100%), 
                        url("https://images.unsplash.com/photo-1436491865332-7a61a109cc05?q=80&w=2074&auto=format&fit=crop") no-repeat center center;
            background-size: cover;
            border-radius: var(--radius-xl);
            margin-bottom: 40px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-main);
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(139, 92, 246, 0.5), transparent);
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            background: rgba(139, 92, 246, 0.12);
            border: 1px solid rgba(139, 92, 246, 0.3);
            border-radius: var(--radius-full);
            color: #d8b4fe;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 24px;
            letter-spacing: 0.04em;
            animation: fadeIn 0.6s ease;
        }

        .hero-logo {
            height: 100px;
            width: auto;
            margin-bottom: 20px;
            border-radius: var(--radius-lg);
            box-shadow: 0 8px 30px rgba(139, 92, 246, 0.35);
            border: 2px solid rgba(255, 255, 255, 0.15);
            animation: floatAirplane 6s ease-in-out infinite;
        }

        .hero-title {
            font-size: 3.6rem;
            font-weight: 800;
            margin-bottom: 18px;
            line-height: 1.15;
            background: linear-gradient(135deg, #ffffff 20%, #c084fc 60%, #818cf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.03em;
            max-width: 850px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-desc {
            font-size: 1.2rem;
            color: var(--text-secondary);
            max-width: 640px;
            margin: 0 auto 36px auto;
            line-height: 1.6;
        }

        .cta-group {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        /* Stats Strip */
        .stats-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 50px;
        }

        .stat-card {
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: var(--accent-color);
            box-shadow: 0 12px 30px rgba(139, 92, 246, 0.15);
        }

        .stat-icon {
            width: 52px;
            height: 52px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .stat-icon-purple {
            background: rgba(139, 92, 246, 0.15);
            color: var(--accent-color);
            border: 1px solid rgba(139, 92, 246, 0.3);
        }

        .stat-icon-cyan {
            background: rgba(6, 182, 212, 0.15);
            color: var(--accent-cyan);
            border: 1px solid rgba(6, 182, 212, 0.3);
        }

        .stat-icon-green {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success-color);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .stat-icon-amber {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning-color);
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.1;
        }

        .stat-label {
            font-size: 0.82rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 2px;
        }

        /* Features Section */
        .section-header-centered {
            text-align: center;
            margin-bottom: 35px;
        }

        .section-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 28px;
            margin-bottom: 60px;
        }

        .info-card {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            padding: 34px 28px;
            position: relative;
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .info-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--accent-gradient);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-6px);
            border-color: rgba(139, 92, 246, 0.4);
            box-shadow: 0 18px 40px -10px rgba(0, 0, 0, 0.6), 0 0 25px rgba(139, 92, 246, 0.18);
        }

        .info-card:hover::after {
            opacity: 1;
        }

        .info-icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: var(--radius-lg);
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(217, 70, 239, 0.2));
            border: 1px solid rgba(139, 92, 246, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.7rem;
            color: var(--accent-color);
            margin-bottom: 22px;
            transition: all 0.3s ease;
        }

        .info-card:hover .info-icon-wrapper {
            background: var(--accent-gradient);
            color: #ffffff;
            box-shadow: 0 8px 24px rgba(139, 92, 246, 0.45);
            transform: scale(1.06);
        }

        .info-card h3 {
            font-size: 1.35rem;
            font-weight: 800;
            margin-bottom: 12px;
            color: #ffffff;
            letter-spacing: -0.01em;
        }

        .info-card p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Map Network Section */
        .map-section {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            padding: 40px;
            text-align: center;
            margin-bottom: 50px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-card);
        }

        .map-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(139, 92, 246, 0.4), transparent);
        }

        .map-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
            max-width: 900px;
            margin-top: 24px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .map-image {
            width: 100%;
            display: block;
            border-radius: var(--radius-lg);
            transition: transform 0.5s ease;
        }

        .map-wrapper:hover .map-image {
            transform: scale(1.02);
        }

        .map-scanline {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(180deg, transparent 40%, rgba(139, 92, 246, 0.12) 50%, transparent 60%);
            pointer-events: none;
            animation: radarSweep 6s infinite linear;
        }

        @keyframes radarSweep {
            0% { transform: translateY(-100%); }
            100% { transform: translateY(100%); }
        }

        /* CTA Bottom Banner */
        .cta-bottom-card {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.15) 0%, rgba(217, 70, 239, 0.15) 100%);
            border: 1px solid rgba(139, 92, 246, 0.35);
            border-radius: var(--radius-xl);
            padding: 45px;
            text-align: center;
            margin-bottom: 50px;
            position: relative;
            overflow: hidden;
        }

        .footer-banner {
            text-align: center;
            padding: 30px;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.4rem;
            }
            .hero-section {
                padding: 50px 20px;
            }
            .cta-bottom-card {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="premium-container">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-badge">
                <span class="radar-dot radar-dot-purple"></span>
                ONLYFLIGHTS • NEXT-GEN AIRLINE OS
            </div>
            
            <div>
                <img src="/OF.jpeg" alt="OnlyFlights Logo" class="hero-logo">
            </div>

            <h1 class="hero-title">Elevate Your Travel Experience</h1>
            <p class="hero-desc">Discover seamless flight schedules, manage partner airports globally, and check in with unparalleled digital precision.</p>
            
            <div class="cta-group">
                <?php if (!session()->get('log')): ?>
                    <a href="/booking/checkin" class="premium-btn premium-btn-primary">
                        <i class="fa-solid fa-ticket"></i> Passenger Check-In
                    </a>
                    <a href="/login" class="premium-btn premium-btn-secondary">
                        <i class="fa-solid fa-shield-halved"></i> Admin Portal
                    </a>
                <?php else: ?>
                    <a href="/flight" class="premium-btn premium-btn-primary">
                        <i class="fa-solid fa-plane"></i> Manage Flights
                    </a>
                    <a href="/airport" class="premium-btn premium-btn-secondary">
                        <i class="fa-solid fa-building-shield"></i> Manage Airports
                    </a>
                    <a href="/finance-dashboard" class="premium-btn premium-btn-secondary">
                        <i class="fa-solid fa-chart-line"></i> Financial Recap
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Live KPI Stats Strip -->
        <div class="stats-strip">
            <div class="stat-card">
                <div class="stat-icon stat-icon-purple">
                    <i class="fa-solid fa-building-shield"></i>
                </div>
                <div>
                    <div class="stat-number">48+</div>
                    <div class="stat-label">Partner Airports</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-cyan">
                    <i class="fa-solid fa-plane-departure"></i>
                </div>
                <div>
                    <div class="stat-number">150+</div>
                    <div class="stat-label">Daily Schedules</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-green">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <div class="stat-number">99.8%</div>
                    <div class="stat-label">On-Time Accuracy</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon stat-icon-amber">
                    <i class="fa-solid fa-qrcode"></i>
                </div>
                <div>
                    <div class="stat-number">Instant</div>
                    <div class="stat-label">Digital Check-In</div>
                </div>
            </div>
        </div>

        <!-- Grid of Features -->
        <div class="section-header-centered">
            <h2 class="page-title" style="font-size: 2.1rem; margin-bottom: 8px;">Built for Modern Aviation</h2>
            <p class="page-subtitle" style="margin-bottom: 0;">Comprehensive flight control, passenger self-service, and real-time operational recap.</p>
        </div>

        <div class="section-grid">
            <div class="info-card">
                <div class="info-icon-wrapper">
                    <i class="fa-solid fa-map-location-dot"></i>
                </div>
                <h3>Global Airport Network</h3>
                <p>Access our comprehensive network of registered partner airports worldwide with accurate IATA codes and geographical routing.</p>
            </div>
            
            <div class="info-card">
                <div class="info-icon-wrapper">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <h3>Schedules & Route Control</h3>
                <p>Manage aircraft routes, capacities, seat availability, ticket pricing, and duration profiles dynamically from a single intuitive dashboard.</p>
            </div>

            <div class="info-card">
                <div class="info-icon-wrapper">
                    <i class="fa-solid fa-ticket-simple"></i>
                </div>
                <h3>Digital Passenger Check-In</h3>
                <p>Fast and hassle-free online boarding pass verification for passengers with real-time seat assignment and booking confirmation.</p>
            </div>
        </div>

        <!-- Map Routes Section -->
        <div class="map-section">
            <h2 class="page-title" style="font-size: 2rem; margin-bottom: 12px;">Dynamic Flight Network Map</h2>
            <p class="page-subtitle" style="margin-bottom: 20px;">Connecting major hubs across continents with scheduled precision.</p>
            
            <div class="map-wrapper">
                <img src="https://www.visualcapitalist.com/wp-content/uploads/2022/09/CP-Adam-Symington-Mapping-Airways-Main.png" alt="World Map with Flight Routes" class="map-image">
                <div class="map-scanline"></div>
            </div>
        </div>

        <!-- Call to Action Banner -->
        <div class="cta-bottom-card">
            <h2 style="font-size: 2rem; font-weight: 800; color: #ffffff; margin-bottom: 12px;">Ready for Departure?</h2>
            <p style="color: var(--text-secondary); max-width: 550px; margin: 0 auto 24px auto;">Access passenger self-service check-in or manage flight logistics through the secure administrative gateway.</p>
            <div style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
                <a href="/booking/checkin" class="premium-btn premium-btn-primary">
                    <i class="fa-solid fa-ticket"></i> Check-In Now
                </a>
                <?php if (!session()->get('log')): ?>
                    <a href="/login" class="premium-btn premium-btn-secondary">
                        <i class="fa-solid fa-right-to-bracket"></i> Admin Access
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <footer class="footer-banner">
        <p>© <?= date('Y') ?> OnlyFlights Airline Management System. All rights reserved.</p>
    </footer>
</body>
</html>
