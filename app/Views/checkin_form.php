<?= view('navbar') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Web Check-in - OnlyFlights</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .checkin-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 170px);
            padding: 30px 20px;
            position: relative;
        }

        .checkin-container {
            position: relative;
            width: 100%;
            max-width: 500px;
        }

        .checkin-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 360px;
            height: 360px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.22) 0%, rgba(139, 92, 246, 0.12) 50%, transparent 70%);
            border-radius: 50%;
            filter: blur(60px);
            pointer-events: none;
            z-index: 0;
            animation: pulseGlow 5s infinite alternate ease-in-out;
        }

        .checkin-card {
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

        .checkin-badge-icon {
            width: 76px;
            height: 76px;
            margin: 0 auto 20px auto;
            border-radius: var(--radius-xl);
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(217, 70, 239, 0.2));
            border: 1px solid rgba(139, 92, 246, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            color: var(--accent-color);
            box-shadow: 0 8px 24px rgba(139, 92, 246, 0.25);
            animation: floatAirplane 5s ease-in-out infinite;
        }

        .checkin-title {
            font-size: 2.1rem;
            font-weight: 800;
            margin-bottom: 8px;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }

        .checkin-subtitle {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-bottom: 30px;
            line-height: 1.5;
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

        .input-field-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .premium-input-icon {
            padding-left: 46px !important;
        }

        .premium-input-icon:focus + i {
            color: var(--accent-color);
            transform: translateY(-50%) scale(1.1);
        }
    </style>
</head>
<body>
    <div class="checkin-wrapper">
        <div class="checkin-container">
            <div class="checkin-glow"></div>
            <div class="checkin-card">
                <div class="checkin-badge-icon">
                    <i class="fa-solid fa-plane-circle-check"></i>
                </div>
                <h2 class="checkin-title">Online Check-In</h2>
                <p class="checkin-subtitle">Verify booking status, retrieve seat information, and download your boarding pass instantly.</p>
                
                <form action="/booking/checkin-result" method="get" class="premium-form">
                    <div class="input-group">
                        <label for="booking_id"><i class="fa-solid fa-barcode" style="color: var(--accent-color);"></i> Booking ID (PNR / Code)</label>
                        <div class="input-field-wrapper">
                            <input type="text" name="booking_id" id="booking_id" class="premium-input premium-input-icon" placeholder="e.g. 5LNJP5, MBSUX0" required autofocus style="text-transform: uppercase; letter-spacing: 0.08em; font-weight: 700;">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="last_name"><i class="fa-solid fa-user-tag" style="color: var(--accent-color);"></i> Passenger Last Name</label>
                        <div class="input-field-wrapper">
                            <input type="text" name="last_name" id="last_name" class="premium-input premium-input-icon" placeholder="e.g. Abdinegara, Nugraha" required>
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </div>
                    
                    <button type="submit" class="premium-btn premium-btn-primary premium-btn-block" style="margin-top: 10px;">
                        <i class="fa-solid fa-passport"></i> Retrieve Booking & Check-In
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
