<?php
require_once 'auth_guard.php';

$username = $user['username'] ?? 'User';
$balance = number_format($user['balance'] ?? 0, 2);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'partials/head.php'; ?>
    <title>My Portfolio - Tenvault</title>
    <style>
    /* Branding Excellence */
    .uc-logo img, .auth-logo img, .header-logo img {
        height: 160px !important;
        width: auto !important;
        object-fit: contain;
        display: block;
        image-rendering: -webkit-optimize-contrast;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
    }
    @media (max-width: 768px) {
        .uc-logo img, .auth-logo img, .header-logo img {
            height: 50px !important;
        }
    }

    /* Portfolio Styles */
    .portfolio-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 1.5rem;
    }

    .portfolio-hero h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        margin: 0 0 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .portfolio-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
    }

    .portfolio-stat-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 1rem;
    }

    .portfolio-stat-card label {
        display: block;
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .portfolio-stat-card .value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #f8fafc;
    }

    .portfolio-stat-card .value.positive { color: #10b981; }
    .portfolio-stat-card .value.negative { color: #ef4444; }

    .holdings-section {
        background: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .holdings-section h2 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #fff;
        margin: 0 0 1rem 0;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #64748b;
    }

    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state p {
        margin: 0 0 1rem 0;
    }

    .empty-state a {
        color: #10b981;
        text-decoration: none;
    }

    .orders-section {
        background: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 1.5rem;
    }

    .orders-section h2 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #fff;
        margin: 0 0 1rem 0;
    }

    /* Light Theme Overrides */
    html:not(.dark) .portfolio-hero {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: 1px solid #e2e8f0;
    }

    html:not(.dark) .portfolio-hero h1 {
        color: #1e293b;
    }

    html:not(.dark) .portfolio-stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
    }

    html:not(.dark) .portfolio-stat-card label {
        color: #64748b;
    }

    html:not(.dark) .portfolio-stat-card .value {
        color: #1e293b;
    }

    html:not(.dark) .holdings-section,
    html:not(.dark) .orders-section {
        background: #ffffff;
        border: 1px solid #e2e8f0;
    }

    html:not(.dark) .holdings-section h2,
    html:not(.dark) .orders-section h2 {
        color: #1e293b;
    }
    </style>
</head>

<body x-data class="is-header-blur" x-bind="$store.global.documentBody" :class="{ 'is-sidebar-open': $store.global.isSidebarExpanded }">
    <div id="root" class="min-h-100vh flex grow bg-slate-50 dark:bg-navy-900">

        <?php include 'partials/sidebar.php'; ?>

        <?php include 'partials/header.php'; ?>

        <main class="main-content w-full px-[var(--margin-x)] pb-8 pt-6">
            <a href="stocks.php" style="display: inline-flex; align-items: center; gap: 8px; color: #64748b; text-decoration: none; font-size: 0.9rem; margin-bottom: 1rem;">
                <i class="fas fa-arrow-left"></i> Back to Stocks
            </a>

            <div class="portfolio-hero">
                <h1><i class="fas fa-briefcase" style="color: #10b981;"></i> My Portfolio</h1>
                <div class="portfolio-stats">
                    <div class="portfolio-stat-card">
                        <label>Portfolio Value</label>
                        <span class="value">$0.00</span>
                    </div>
                    <div class="portfolio-stat-card">
                        <label>Total Invested</label>
                        <span class="value">$0.00</span>
                    </div>
                    <div class="portfolio-stat-card">
                        <label>Total P/L</label>
                        <span class="value positive">+$0.00</span>
                    </div>
                    <div class="portfolio-stat-card">
                        <label>Return</label>
                        <span class="value positive">+0.00%</span>
                    </div>
                </div>
            </div>

            <div class="holdings-section">
                <h2><i class="fas fa-chart-pie" style="color: #64748b; margin-right: 8px;"></i>Holdings</h2>
                <div class="empty-state">
                    <i class="fas fa-chart-pie"></i>
                    <p>You don't own any stocks yet.</p>
                    <a href="stocks.php"><i class="fas fa-plus"></i> Browse Stocks</a>
                </div>
            </div>

            <div class="orders-section">
                <h2><i class="fas fa-history" style="color: #64748b; margin-right: 8px;"></i>Recent Orders</h2>
                <div class="empty-state">
                    <i class="fas fa-history"></i>
                    <p>No orders yet.</p>
                </div>
            </div>
        </main>
    </div>

    <script>
        window.addEventListener("DOMContentLoaded", () => Alpine.start());
    </script>
</body>
</html>
