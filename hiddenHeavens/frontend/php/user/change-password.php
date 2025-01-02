<?php
require '../db.php'; // Include the database connection
session_start(); // Start session to access user data

header('Content-Type: application/json'); // Set JSON response type

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['status' => 'error', 'message' => 'You are not logged in.']);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_new_password = trim($_POST['confirm_new_password']);

    // Validate input
    if (empty($current_password) || empty($new_password) || empty($confirm_new_password)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    if ($new_password !== $confirm_new_password) {
        echo json_encode(['status' => 'error', 'message' => 'New passwords do not match.']);
        exit;
    }

    if (strlen($new_password) < 6) {
        echo json_encode(['status' => 'error', 'message' => 'New password must be at least 6 characters long.']);
        exit;
    }

    // Fetch the current password from the database
    $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($current_password, $user['password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
        exit;
    }

    // Hash the new password and update it in the database
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->execute([$hashed_password, $user_id]);

    echo json_encode(['status' => 'success', 'message' => 'Password updated successfully.']);
    exit;
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}
?>
