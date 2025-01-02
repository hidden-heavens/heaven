<?php
require '../db.php'; // Include the database connection
session_start(); // Start a session for user login

header('Content-Type: application/json'); // Set JSON response type

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Safely retrieve form inputs
    $email = isset($_POST['email']) ? trim($_POST['email']) : null;
    $password = isset($_POST['password']) ? trim($_POST['password']) : null;

    // Server-side validation
    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    try {
        // Fetch user data from the database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Check if the user exists and verify the password
        if ($user && password_verify($password, $user['password'])) {
            // Check if the account is locked due to failed attempts
            if ($user['failed_attempts'] >= 5) {
                echo json_encode(['status' => 'error', 'message' => 'Your account is locked due to multiple failed login attempts. Please contact support.']);
                exit;
            }

            // Check if the account is manually locked
            if ($user['status'] === 'locked') {
                echo json_encode(['status' => 'error', 'message' => 'Your account is locked. Please contact support.']);
                exit;
            }

            // Check if the email is not verified
            if ($user['status'] === 'inactive' && empty($user['email_verified_at'])) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Your email is not verified. Please check your inbox or click below to resend the verification email.',
                    'action' => 'resend'
                ]);
                exit;
            }

            // Update login metadata
            $stmt = $pdo->prepare("UPDATE users SET failed_attempts = 0, last_login = GETDATE(), last_ip = ? WHERE id = ?");
            $stmt->execute([$_SERVER['REMOTE_ADDR'], $user['id']]);

            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            // Store user data in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone_number'] = $user['phone_number'];
            $_SESSION['location'] = $user['location'];

            // Redirect to the home page
            echo json_encode(['status' => 'success', 'redirect' => '../../index.php']);
            exit;
        } else {
            // Increment failed attempts for invalid login
            if ($user) {
                $stmt = $pdo->prepare("UPDATE users SET failed_attempts = failed_attempts + 1 WHERE id = ?");
                $stmt->execute([$user['id']]);
            }
            echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
