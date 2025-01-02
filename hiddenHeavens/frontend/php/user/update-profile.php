<?php
require '../db.php'; // Include the database connection
session_start(); // Start the session

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Retrieve user input from the form
$user_id = $_SESSION['user_id'];
$username = trim($_POST['username']);
$phone_number = trim($_POST['phone_number']);
$location = trim($_POST['location']);

// Validate input
if (empty($username)) {
    echo "Username is required.";
    exit;
}

// Update user data in the database
$stmt = $pdo->prepare("UPDATE users SET username = ?, phone_number = ?, location = ? WHERE id = ?");
$stmt->execute([$username, $phone_number, $location, $user_id]);

// Refresh session data
$_SESSION['username'] = $username;
$_SESSION['phone_number'] = $phone_number;
$_SESSION['location'] = $location;

// Redirect back to the account page
header("Location: ../../account.php");
exit;
?>
