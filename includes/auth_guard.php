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

// Process profits periodically
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/FinanceManager.php';

// Fetch user data globally for all account pages
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user) {
    session_destroy();
    header('Location: login/index.php');
    exit();
}

$finance = new FinanceManager($pdo);
$finance->processProfits();
?>
