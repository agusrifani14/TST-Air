<?php
$sales = isset($response_finance["sales"]) ? $response_finance["sales"] : [];
$message = isset($response_finance["message"]) ? $response_finance["message"] : '';
$total = 0;
$flight_count = count($sales);

foreach ($sales as $sale) {
    $total += isset($sale["revenue"]) ? (float)$sale["revenue"] : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Financial Recap - OnlyFlights</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <style>
        .finance-summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
            margin-bottom: 35px;
        }

        .summary-card {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-xl);
            padding: 28px 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: var(--shadow-card);
            position: relative;
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .summary-card:hover {
            transform: translateY(-4px);
            border-color: var(--accent-color);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5), 0 0 25px rgba(139, 92, 246, 0.15);
        }
        
        .summary-card::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.12) 0%, transparent 70%);
            right: -40px;
            bottom: -40px;
            border-radius: 50%;
            pointer-events: none;
        }

        .summary-icon {
            width: 64px;
            height: 64px;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .summary-card:hover .summary-icon {
            transform: scale(1.08);
        }

        .summary-info {
            display: flex;
            flex-direction: column;
        }

        .summary-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 4px;
        }

        .summary-val {
            font-size: 1.85rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
            font-family: var(--font-heading);
        }
        
        .source-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: var(--radius-full);
            font-size: 0.82rem;
            font-weight: 700;
        }
        
        .source-badge-api {
            background-color: rgba(16, 185, 129, 0.15);
            color: var(--success-color);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .source-badge-local {
            background-color: rgba(245, 158, 11, 0.15);
            color: var(--warning-color);
            border: 1px solid rgba(245, 158, 11, 0.3);
        }
    </style>
</head>
<body>
    <div class="premium-container">
        <h1 class="page-title">Financial Recap</h1>
        <p class="page-subtitle">Analyze flight revenues, ticket sales performance, and monthly statistics</p>

        <!-- Metric Summary Cards -->
        <div class="finance-summary-grid">
            <div class="summary-card">
                <div class="summary-icon" style="color: var(--success-color); background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3);">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div class="summary-info">
                    <span class="summary-label">Total Gross Revenue</span>
                    <span class="summary-val" style="color: var(--success-color);">Rp <?= number_format($total, 0, ',', '.'); ?></span>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon" style="color: var(--accent-color); background: rgba(139, 92, 246, 0.15); border: 1px solid rgba(139, 92, 246, 0.3);">
                    <i class="fa-solid fa-plane-up"></i>
                </div>
                <div class="summary-info">
                    <span class="summary-label">Total Transactions</span>
                    <span class="summary-val"><?= $flight_count; ?> Records</span>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon" style="color: var(--warning-color); background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3);">
                    <i class="fa-solid fa-database"></i>
                </div>
                <div class="summary-info">
                    <span class="summary-label">Data Integration Status</span>
                    <div>
                        <?php if (strpos($message, 'Local') !== false): ?>
                            <span class="source-badge source-badge-local">
                                <span class="radar-dot radar-dot-purple" style="background-color: var(--warning-color);"></span> Local Database Fallback
                            </span>
                        <?php else: ?>
                            <span class="source-badge source-badge-api">
                                <span class="radar-dot radar-dot-green"></span> Live Ticketing API
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Report Card -->
        <div class="premium-card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 22px;">
                <p style="font-size: 1.3rem; font-weight: 800; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-chart-pie" style="color: var(--accent-color);"></i> Monthly Flight Earnings Breakdown
                </p>

                <div class="filter-search-wrapper" style="max-width: 320px;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="financeSearchInput" class="filter-search-input" placeholder="Search by month or flight ID...">
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="premium-table" id="financeTable">
                    <thead>
                        <tr>
                            <th>Month Period</th>
                            <th>Flight ID</th>
                            <th style="text-align: right;">Gross Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($sales)): ?>
                            <?php foreach ($sales as $sale): ?>
                            <tr class="finance-row">
                                <td style="font-weight: 700; color: var(--text-primary);">
                                    <i class="fa-regular fa-calendar" style="color: var(--accent-color); margin-right: 6px;"></i>
                                    <?= esc(isset($sale["MONTH"]) ? $sale["MONTH"] : 'Unknown'); ?>
                                </td>
                                <td style="font-weight: 800; color: #c084fc; font-family: var(--font-heading); font-size: 1.05rem;">
                                    <?= esc(isset($sale["flight_id"]) ? $sale["flight_id"] : 'N/A'); ?>
                                </td>
                                <td style="font-weight: 700; color: var(--success-color); text-align: right; font-size: 1.05rem;">
                                    Rp <?= number_format(isset($sale["revenue"]) ? (float)$sale["revenue"] : 0, 0, ',', '.'); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" style="text-align: center; color: var(--text-muted); padding: 40px 0;">
                                    <i class="fa-solid fa-folder-open" style="font-size: 2rem; margin-bottom: 12px; display: block;"></i>
                                    No sales records found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var searchInput = document.getElementById('financeSearchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    var val = this.value.toLowerCase();
                    var rows = document.querySelectorAll('#financeTable tbody tr.finance-row');
                    rows.forEach(function(row) {
                        row.style.display = row.textContent.toLowerCase().indexOf(val) > -1 ? '' : 'none';
                    });
                });
            }
        });
    </script>
</body>
</html>
