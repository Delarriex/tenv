<?php
require_once('auth_check.php');
require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['user_id'], $_POST['action'])) {
    $kycId = (int)$_POST['id'];
    $userId = (int)$_POST['user_id'];
    $action = $_POST['action'];
    $reason = $_POST['reason'] ?? '';

    try {
        $pdo->beginTransaction();

        $status = ($action === 'approve') ? 'approved' : 'rejected';
        
        // Update KYC record
        $stmt = $pdo->prepare("UPDATE kyc SET status = ?, admin_note = ? WHERE id = ?");
        $stmt->execute([$status, $reason, $kycId]);

        // Sync with users table if approved
        if ($status === 'approved') {
            $stmt = $pdo->prepare("UPDATE users SET is_verified = 1 WHERE id = ?");
            $stmt->execute([$userId]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET is_verified = 0 WHERE id = ?");
            $stmt->execute([$userId]);
        }

        $pdo->commit();
        header('Location: kyc.php?success=1');
    } catch (Exception $e) {
        $pdo->rollBack();
        header('Location: kyc.php?error=' . urlencode($e->getMessage()));
    }
} else {
    header('Location: kyc.php');
}
exit();
?>
