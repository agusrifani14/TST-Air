<?= view('navbar') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Login - OnlyFlights</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 170px);
            padding: 30px 20px;
            position: relative;
        }

        .login-card-container {
            position: relative;
            width: 100%;
            max-width: 440px;
        }

        .login-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 320px;
            height: 320px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.25) 0%, rgba(217, 70, 239, 0.1) 50%, transparent 70%);
            border-radius: 50%;
            filter: blur(50px);
            pointer-events: none;
            z-index: 0;
            animation: pulseGlow 6s infinite alternate ease-in-out;
        }

        .login-card {
            position: relative;
            z-index: 1;
            background: var(--bg-card);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), 0 0 30px rgba(139, 92, 246, 0.15);
            padding: 42px 36px;
            text-align: center;
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .login-logo {
            height: 90px;
            width: auto;
            margin-bottom: 20px;
            border-radius: var(--radius-lg);
            box-shadow: 0 6px 22px rgba(139, 92, 246, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: transform 0.3s ease;
        }

        .login-logo:hover {
            transform: scale(1.05) rotate(-2deg);
        }

        .login-title {
            font-size: 2.1rem;
            font-weight: 800;
            margin-bottom: 8px;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }

        .login-subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-bottom: 32px;
        }

        .input-group {
            position: relative;
            margin-bottom: 22px;
            text-align: left;
        }

        .input-group label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-secondary);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .input-field-wrapper {
            position: relative;
        }

        .input-field-wrapper i.field-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .input-field-wrapper input:focus ~ i.field-icon {
            color: var(--accent-color);
            transform: translateY(-50%) scale(1.1);
        }

        .premium-input-icon {
            padding-left: 46px !important;
            padding-right: 44px !important;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 4px;
            font-size: 0.95rem;
            transition: color 0.2s ease;
        }

        .password-toggle:hover {
            color: var(--text-primary);
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card-container">
            <div class="login-glow"></div>
            <div class="login-card">
                <img src="/OF.jpeg" alt="OnlyFlights Logo" class="login-logo">
                <h2 class="login-title">Admin Console</h2>
                <p class="login-subtitle">Sign in to manage flight schedules and partner airports</p>
                
                <form action="/login-process" method="POST" class="premium-form">
                    <?= csrf_field() ?>
                    <div class="input-group">
                        <label for="email"><i class="fa-solid fa-envelope" style="color: var(--accent-color);"></i> Admin Email</label>
                        <div class="input-field-wrapper">
                            <input type="text" name="email" id="email" class="premium-input premium-input-icon" placeholder="admin@onlyflights.18s" required autofocus>
                            <i class="fa-solid fa-envelope field-icon"></i>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="password"><i class="fa-solid fa-lock" style="color: var(--accent-color);"></i> Password</label>
                        <div class="input-field-wrapper">
                            <input type="password" name="password" id="password" class="premium-input premium-input-icon" placeholder="••••••••" required>
                            <i class="fa-solid fa-lock field-icon"></i>
                            <button type="button" class="password-toggle" id="togglePassword" aria-label="Toggle password visibility">
                                <i class="fa-solid fa-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>
                    
                    <button type="submit" class="premium-btn premium-btn-primary premium-btn-block" style="margin-top: 14px;">
                        <i class="fa-solid fa-right-to-bracket"></i> Login to Console
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            var passwordField = document.getElementById('password');
            var icon = document.getElementById('togglePasswordIcon');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
