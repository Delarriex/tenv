<?php
require_once('auth_check.php');
require_once('../config/db.php');
require_once('../includes/FinanceManager.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['action'])) {
    $txId = (int)$_POST['id'];
    $action = $_POST['action'];
    $note = $_POST['note'] ?? '';

    $finance = new FinanceManager($pdo);
    $status = ($action === 'approve') ? 'completed' : 'failed';

    if ($finance->updateTransactionStatus($txId, $status, $note)) {
        header('Location: index.php?success=1');
    } else {
        header('Location: index.php?error=1');
    }
    exit();
} else {
    header('Location: index.php');
    exit();
}
?>
