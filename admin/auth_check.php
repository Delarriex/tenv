<?php
session_start();
require_once(__DIR__ . '/../config/db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/index.php');
    exit();
}

$stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$userRole = $stmt->fetchColumn();

if ($userRole !== 'admin') {
    die("Access Denied: You do not have administrator privileges.");
}
?>
