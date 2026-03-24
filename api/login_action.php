<?php
/**
 * User Login Action
 */
session_start();
require_once('../config/db.php');

$response = ['status' => 'error', 'message' => 'Invalid credentials.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Login success
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];

                $response['status'] = 'success';
                $response['message'] = 'Login successful! Redirecting...';
                $response['redirect'] = '../dashboard.php';
            }
        } catch (\PDOException $e) {
            $response['message'] = 'Error: ' . $e->getMessage();
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
