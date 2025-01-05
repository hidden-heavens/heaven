<?php
// php/reviews/get-review.php

header('Content-Type: application/json');
session_start();
require '../db.php'; // Adjust the path if necessary

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not authenticated.']);
    exit;
}

$userId = $_SESSION['user_id'];

// Check if ID is provided
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Review ID is required.']);
    exit;
}

$reviewId = $_POST['id'];

// Verify that the review belongs to the user
try {
    $stmt = $pdo->prepare("SELECT id, rating, comment FROM reviews WHERE id = ? AND user_id = ?");
    $stmt->execute([$reviewId, $userId]);
    $review = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$review) {
        echo json_encode(['status' => 'error', 'message' => 'Review not found or access denied.']);
        exit;
    }

    echo json_encode(['status' => 'success', 'data' => $review]);
    exit;
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . htmlspecialchars($e->getMessage())]);
    exit;
}
?>
