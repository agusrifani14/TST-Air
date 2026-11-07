<?= view('navbar') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Check-in Boarding Pass - OnlyFlights</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .result-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 180px);
            padding: 40px 24px;
        }

        /* Boarding Pass Ticket Styling */
        .boarding-pass {
            width: 100%;
            max-width: 650px;
            background: linear-gradient(135deg, #1e1b29 0%, #12101a 100%);
            border: 2px solid rgba(139, 92, 246, 0.3);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            position: relative;
        }

        .ticket-header {
            background: var(--accent-gradient);
            padding: 24px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px dashed rgba(255, 255, 255, 0.15);
        }

        .ticket-header-logo {
            font-size: 1.3rem;
            font-weight: 800;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ticket-type {
            font-size: 0.8rem;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 4px 12px;
            border-radius: 50px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .ticket-body {
            padding: 32px;
        }

        .ticket-row {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }
        
        .ticket-col-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
            margin-bottom: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 20px 0;
        }

        .ticket-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }

        .ticket-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #ffffff;
        }

        .ticket-value-large {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--accent-color);
        }

        /* Custom design for route */
        .route-display {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            background: rgba(255, 255, 255, 0.02);
            padding: 16px 24px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        .route-airport {
            display: flex;
            flex-direction: column;
        }

        .route-code {
            font-size: 1.8rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1;
        }

        .route-name {
            font-size: 0.8rem;
            color: var(--text-secondary);
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            margin-top: 4px;
        }

        .route-icon {
            font-size: 1.5rem;
            color: var(--accent-color);
            position: relative;
        }

        /* Fake Barcode styling */
        .barcode-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 15px;
            padding-top: 20px;
            border-top: 2px dashed rgba(255, 255, 255, 0.1);
        }

        .barcode {
            width: 100%;
            height: 60px;
            background: repeating-linear-gradient(
                90deg,
                #ffffff,
                #ffffff 2px,
                #12101a 2px,
                #12101a 6px,
                #ffffff 6px,
                #ffffff 7px,
                #12101a 7px,
                #12101a 9px
            );
            border-radius: 4px;
            opacity: 0.8;
            margin-bottom: 8px;
        }

        .barcode-text {
            font-family: monospace;
            font-size: 0.85rem;
            color: var(--text-secondary);
            letter-spacing: 0.3em;
        }

        /* Alert styling for failed state */
        .status-card {
            width: 100%;
            max-width: 500px;
            background: var(--bg-card);
            backdrop-filter: blur(16px);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 40px;
            text-align: center;
            box-shadow: var(--shadow-main);
        }

        .status-icon {
            font-size: 3.5rem;
            margin-bottom: 20px;
        }

        .status-icon-error {
            color: var(--danger-color);
        }

        .status-icon-warning {
            color: var(--warning-color);
        }

        .status-title {
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .status-message {
            color: var(--text-secondary);
            margin-bottom: 30px;
            line-height: 1.5;
        }

        /* Print styling */
        @media print {
            body * {
                visibility: hidden;
            }
            .boarding-pass, .boarding-pass * {
                visibility: visible;
            }
            .boarding-pass {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: none;
                box-shadow: none;
            }
            .print-btn-container {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="result-wrapper">
        <?php if (isset($checkin_result) && $checkin_result !== null): ?>
            <!-- Beautiful Digital Boarding Pass -->
            <div>
                <div class="boarding-pass">
                    <!-- Ticket Header -->
                    <div class="ticket-header">
                        <div class="ticket-header-logo">
                            <i class="fa-solid fa-plane-departure"></i>
                            <span>ONLYFLIGHTS</span>
                        </div>
                        <span class="ticket-type">Boarding Pass</span>
                    </div>
                    
                    <!-- Ticket Details -->
                    <div class="ticket-body">
                        <!-- Route display codes -->
                        <div class="route-display">
                            <div class="route-airport">
                                <span class="route-code"><?= esc(isset($checkin_result['origin_iata']) ? $checkin_result['origin_iata'] : 'DEP') ?></span>
                                <span class="route-name"><?= esc($checkin_result['departure_airport']); ?></span>
                            </div>
                            <div class="route-icon">
                                <i class="fa-solid fa-plane"></i>
                            </div>
                            <div class="route-airport" style="text-align: right;">
                                <span class="route-code"><?= esc(isset($checkin_result['dest_iata']) ? $checkin_result['dest_iata'] : 'ARR') ?></span>
                                <span class="route-name"><?= esc($checkin_result['arrival_airport']); ?></span>
                            </div>
                        </div>

                        <!-- Passenger Row -->
                        <div class="ticket-row">
                            <div>
                                <div class="ticket-label">Passenger Name</div>
                                <div class="ticket-value"><?= esc($checkin_result['honorifics']) . ' ' . esc($checkin_result['first_name']) . ' ' . esc($checkin_result['last_name']); ?></div>
                            </div>
                            <div>
                                <div class="ticket-label">Booking Reference (PNR)</div>
                                <div class="ticket-value-large" style="letter-spacing: 0.05em;"><?= esc($checkin_result['booking_id']); ?></div>
                            </div>
                        </div>

                        <!-- Flight Grid details -->
                        <div class="ticket-col-3">
                            <div>
                                <div class="ticket-label">Flight ID</div>
                                <div class="ticket-value" style="color: var(--accent-color);"><?= esc($checkin_result['flight_id']); ?></div>
                            </div>
                            <div>
                                <div class="ticket-label">Departure Date</div>
                                <div class="ticket-value"><?= date('d M Y', strtotime($checkin_result['departure_date'])); ?></div>
                            </div>
                            <div>
                                <div class="ticket-label">Seat Number</div>
                                <div class="ticket-value" style="color: var(--success-color); font-size: 1.3rem;"><i class="fa-solid fa-chair"></i> <?= esc($checkin_result['seat_num']); ?></div>
                            </div>
                        </div>

                        <!-- Simulated Barcode -->
                        <div class="barcode-container">
                            <div class="barcode"></div>
                            <div class="barcode-text"><?= esc($checkin_result['booking_id']); ?>-<?= esc($checkin_result['flight_id']); ?></div>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="print-btn-container" style="display: flex; gap: 12px; justify-content: center; margin-top: 30px;">
                    <a href="/booking/checkin" class="premium-btn premium-btn-secondary"><i class="fa-solid fa-arrow-left"></i> Check-in Another</a>
                    <button onclick="window.print();" class="premium-btn premium-btn-primary"><i class="fa-solid fa-print"></i> Print Boarding Pass</button>
                </div>
            </div>

        <?php elseif (isset($error) && !empty($error)): ?>
            <!-- Ticketing Service Offline / Connection Error -->
            <div class="status-card">
                <div class="status-icon status-icon-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                </div>
                <h2 class="status-title">Service Unavailable</h2>
                <p class="status-message"><?= esc($error); ?></p>
                <a href="/booking/checkin" class="premium-btn premium-btn-primary"><i class="fa-solid fa-rotate-left"></i> Try Again</a>
            </div>

        <?php else: ?>
            <!-- Booking Not Found -->
            <div class="status-card">
                <div class="status-icon status-icon-warning">
                    <i class="fa-solid fa-circle-question"></i>
                </div>
                <h2 class="status-title">Booking Not Found</h2>
                <p class="status-message">We couldn't retrieve any passenger records matching that Booking ID and Last Name. Please verify your details and try again.</p>
                <a href="/booking/checkin" class="premium-btn premium-btn-primary"><i class="fa-solid fa-rotate-left"></i> Re-enter Details</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
