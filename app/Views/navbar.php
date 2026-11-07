<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar-container {
            width: 100%;
            background: rgba(11, 13, 22, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar {
            max-width: 1240px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            height: 74px;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.45rem;
            font-weight: 800;
            text-decoration: none;
            color: #ffffff;
            letter-spacing: -0.02em;
        }

        .nav-logo-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(217, 70, 239, 0.2));
            border: 1px solid rgba(139, 92, 246, 0.3);
            border-radius: var(--radius-md);
            color: var(--accent-color);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .nav-logo:hover .nav-logo-icon {
            transform: translateY(-2px) rotate(-12deg);
            background: var(--accent-gradient);
            color: #ffffff;
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
        }

        .nav-logo-text {
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 6px;
            list-style: none;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-secondary);
            text-decoration: none;
            padding: 9px 15px;
            font-size: 0.92rem;
            font-weight: 600;
            border-radius: var(--radius-md);
            transition: all 0.25s ease;
        }

        .nav-link i {
            font-size: 0.95rem;
            transition: transform 0.2s ease;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background: rgba(255, 255, 255, 0.06);
            transform: translateY(-1px);
        }

        .nav-link:hover i {
            transform: scale(1.1);
            color: var(--accent-color);
        }

        .nav-link.active {
            color: #ffffff;
            background: rgba(139, 92, 246, 0.16);
            border: 1px solid rgba(139, 92, 246, 0.28);
        }

        /* Dropdown style */
        .nav-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            background: rgba(17, 19, 31, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-main);
            min-width: 250px;
            padding: 8px;
            display: none;
            flex-direction: column;
            gap: 4px;
            margin-top: 10px;
            animation: slideDown 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            z-index: 1001;
        }

        .nav-dropdown::before {
            content: '';
            position: absolute;
            top: -12px;
            left: 0;
            width: 100%;
            height: 12px;
            background: transparent;
        }

        .nav-item:hover .nav-dropdown {
            display: flex;
        }

        .dropdown-link {
            display: flex;
            flex-direction: column;
            color: var(--text-secondary);
            text-decoration: none;
            padding: 10px 14px;
            font-size: 0.9rem;
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
        }

        .dropdown-link span {
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .dropdown-link small {
            font-size: 0.76rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        .dropdown-link:hover {
            background: rgba(255, 255, 255, 0.06);
            transform: translateX(4px);
        }
        
        .dropdown-link:hover span {
            color: var(--accent-color);
        }

        .user-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: var(--radius-full);
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.25);
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--success-color);
            margin-left: 6px;
        }

        .logout-btn {
            background: rgba(239, 68, 68, 0.12);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.25);
        }
        
        .logout-btn:hover {
            background: var(--danger-color) !important;
            color: #ffffff !important;
            border-color: var(--danger-color) !important;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.35);
        }

        /* Mobile Hamburger Toggle */
        .nav-toggle-btn {
            display: none;
            background: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            font-size: 1.25rem;
            width: 42px;
            height: 42px;
            border-radius: var(--radius-md);
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .nav-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: var(--accent-color);
            color: var(--accent-color);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive breakpoints */
        @media (max-width: 992px) {
            .nav-toggle-btn {
                display: inline-flex;
            }

            .nav-menu {
                position: absolute;
                top: 74px;
                left: 0;
                width: 100%;
                background: rgba(11, 13, 22, 0.98);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-bottom: 1px solid var(--border-color);
                flex-direction: column;
                align-items: stretch;
                padding: 16px 20px;
                gap: 8px;
                display: none;
                animation: slideDown 0.3s ease forwards;
            }

            .nav-menu.active {
                display: flex;
            }

            .nav-dropdown {
                position: static;
                box-shadow: none;
                border: 1px solid rgba(255, 255, 255, 0.05);
                margin: 4px 0 8px 12px;
                display: flex;
                background: rgba(255, 255, 255, 0.02);
            }

            .nav-item:hover .nav-dropdown {
                display: flex;
            }

            .user-status-pill {
                align-self: flex-start;
                margin: 8px 0;
            }
        }
    </style>
</head>
<body>

<div class="navbar-container">
    <nav class="navbar">
        <a href="/" class="nav-logo">
            <span class="nav-logo-icon">
                <i class="fa-solid fa-plane-departure"></i>
            </span>
            <span class="nav-logo-text">OnlyFlights</span>
        </a>

        <button class="nav-toggle-btn" id="navToggleBtn" aria-label="Toggle navigation">
            <i class="fa-solid fa-bars"></i>
        </button>
        
        <ul class="nav-menu" id="navMenu">
            <li class="nav-item">
                <a href="/" class="nav-link"><i class="fa-solid fa-house"></i> Home</a>
            </li>
            
            <?php if (session()->get('log')): ?>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fa-solid fa-plane"></i> Flights <i class="fa-solid fa-chevron-down" style="font-size: 0.72rem; margin-left: 2px;"></i></a>
                    <div class="nav-dropdown">
                        <a href="/flight" class="dropdown-link">
                            <span><i class="fa-solid fa-list-check" style="color: var(--accent-color);"></i> Manage Flights</span>
                            <small>View and edit schedules</small>
                        </a>
                        <a href="/flight/add-flight" class="dropdown-link">
                            <span><i class="fa-solid fa-circle-plus" style="color: var(--success-color);"></i> Add New Flight</span>
                            <small>Register new route schedule</small>
                        </a>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="fa-solid fa-building-shield"></i> Airports <i class="fa-solid fa-chevron-down" style="font-size: 0.72rem; margin-left: 2px;"></i></a>
                    <div class="nav-dropdown">
                        <a href="/airport" class="dropdown-link">
                            <span><i class="fa-solid fa-earth-asia" style="color: var(--accent-color);"></i> Partner Airports</span>
                            <small>View registered airports</small>
                        </a>
                        <a href="/airport/add-airport" class="dropdown-link">
                            <span><i class="fa-solid fa-circle-plus" style="color: var(--success-color);"></i> Add New Airport</span>
                            <small>Register new partner airport</small>
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <a href="/booking/checkin" class="nav-link"><i class="fa-solid fa-ticket"></i> Passenger Check-In</a>
                </li>
                
                <li class="nav-item">
                    <a href="/finance-dashboard" class="nav-link"><i class="fa-solid fa-chart-line"></i> Financial Recap</a>
                </li>

                <li class="nav-item">
                    <span class="user-status-pill">
                        <span class="radar-dot radar-dot-green"></span> Admin
                    </span>
                </li>
                
                <li class="nav-item">
                    <a href="/logout" class="nav-link logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a href="/booking/checkin" class="nav-link"><i class="fa-solid fa-ticket"></i> Passenger Check-In</a>
                </li>
                <li class="nav-item">
                    <a href="/login" class="nav-link" style="background: rgba(139, 92, 246, 0.15); border: 1px solid rgba(139, 92, 246, 0.3); color: #ffffff;">
                        <i class="fa-solid fa-shield-halved" style="color: var(--accent-color);"></i> Admin Login
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<script>
    // Responsive hamburger menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        var toggleBtn = document.getElementById('navToggleBtn');
        var menu = document.getElementById('navMenu');
        if (toggleBtn && menu) {
            toggleBtn.addEventListener('click', function() {
                menu.classList.toggle('active');
                var icon = toggleBtn.querySelector('i');
                if (icon) {
                    if (menu.classList.contains('active')) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-xmark');
                    } else {
                        icon.classList.remove('fa-xmark');
                        icon.classList.add('fa-bars');
                    }
                }
            });
        }

        // Highlight active link matching current pathname
        var currentPath = window.location.pathname;
        var links = document.querySelectorAll('.nav-link, .dropdown-link');
        links.forEach(function(link) {
            var href = link.getAttribute('href');
            if (href && href !== '#' && href !== '/' && currentPath.indexOf(href) === 0) {
                link.classList.add('active');
            } else if (href === '/' && currentPath === '/') {
                link.classList.add('active');
            }
        });
    });
</script>
