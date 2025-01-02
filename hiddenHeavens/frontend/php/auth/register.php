<?php
require '../db.php'; // Include the database connection

header('Content-Type: application/json'); // Set JSON response type

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
        exit;
    }
    if ($password !== $confirm_password) {
        echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
        exit;
    }
    if (strlen($password) < 6) {
        echo json_encode(['status' => 'error', 'message' => 'Password must be at least 6 characters long.']);
        exit;
    }

    // Generate a verification token
    $verification_token = bin2hex(random_bytes(32));
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, status, verification_token) VALUES (?, ?, ?, 'inactive', ?)");
        $stmt->execute([$username, $email, $hashed_password, $verification_token]);

        // Send verification email
        require 'send_verification_email.php';
        if (sendVerificationEmail($email, $username, $verification_token)) {
            echo json_encode(['status' => 'success', 'message' => 'Registration successful! Please check your email to verify your account.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Registration successful, but we could not send the verification email.']);
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo json_encode(['status' => 'error', 'message' => 'Email or username already exists.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Registration failed: ' . $e->getMessage()]);
        }
    }
}
?>
