<?php
require '../db.php'; // Include the database connection

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify the token and activate the account
    $stmt = $pdo->prepare("SELECT * FROM users WHERE verification_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        // Update user status and set the email_verified_at timestamp
        $stmt = $pdo->prepare("UPDATE users SET status = 'active', email_verified_at = GETDATE(), verification_token = NULL WHERE id = ?");
        $stmt->execute([$user['id']]);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verified</title>
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/style.css">
    <script>
        // Redirect to login page after 5 seconds
        setTimeout(function() {
            window.location.href = '../../login.php';
        }, 5000);
    </script>
</head>
<body>
    <div class="container text-center mt-5">
        <h1 class="text-success">Email Verified</h1>
        <p class="mt-3">Your email has been successfully verified! You can now log in.</p>
        <p>You will be redirected to the login page in <span id="countdown">10</span> seconds...</p>
        <a href="../../login.php" class="btn btn-primary mt-3">Go to Login Page</a>
    </div>
    <script>
        // Countdown timer
        let countdown = 10;
        const countdownElement = document.getElementById('countdown');
        setInterval(function() {
            if (countdown > 1) {
                countdown--;
                countdownElement.textContent = countdown;
            }
        }, 1000);
    </script>
</body>
</html>
