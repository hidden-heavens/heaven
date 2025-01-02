<?php
require '../db.php';
require 'send_verification_email.php'; // Ensure this includes the email-sending logic

header('Content-Type: application/json'); // Set JSON response type

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;

    if (empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Email is required.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT username, verification_token, email_verified_at FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            if (!empty($user['email_verified_at'])) {
                echo json_encode(['status' => 'error', 'message' => 'This email is already verified.']);
                exit;
            }

            // Resend the verification email
            if (sendVerificationEmail($email, $user['username'], $user['verification_token'])) {
                echo json_encode(['status' => 'success', 'message' => 'Verification email has been resent. Please check your inbox.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to send verification email.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Email not found.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
}
?>
