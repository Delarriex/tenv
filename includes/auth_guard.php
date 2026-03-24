<?php
/**
 * Authentication Guard
 * Include this at the top of any page that requires a logged-in user.
 */
session_start();

if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not logged in
    header('Location: login/index.php');
    exit();
}

// Process profits periodically (simple simulation)
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/FinanceManager.php';
$finance = new FinanceManager($pdo);
// In a real app, you'd only run this once every hour/day
$finance->processProfits();
?>
