<?php
/**
 * User Registration Action
 */
require_once('../config/db.php');

$response = ['status' => 'error', 'message' => 'Something went wrong.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $response['message'] = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Invalid email address.';
    } else {
        try {
            // Check if username already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->fetch()) {
                $response['message'] = 'Username or email already exists.';
            } else {
                // Register user
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, full_name, balance) VALUES (?, ?, ?, ?, 0.00)");
                if ($stmt->execute([$username, $email, $hashedPassword, $full_name])) {
                    $response['status'] = 'success';
                    $response['message'] = 'Registration successful! You can now log in.';
                } else {
                    $response['message'] = 'Registration failed. Please try again.';
                }
            }
        } catch (\PDOException $e) {
            $response['message'] = 'Error: ' . $e->getMessage();
        }
    }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
