<?php
// php/reviews/edit-review.php

header('Content-Type: application/json');
session_start();
require '../db.php'; // Adjust the path if necessary

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not authenticated.']);
    exit;
}

$userId = $_SESSION['user_id'];

// Check if all required fields are provided
if (!isset($_POST['id']) || empty($_POST['id']) ||
    !isset($_POST['rating']) || empty($_POST['rating']) ||
    !isset($_POST['comment']) || empty($_POST['comment'])) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

$reviewId = $_POST['id'];
$rating = intval($_POST['rating']);
$comment = trim($_POST['comment']);

// Validate rating
if ($rating < 1 || $rating > 5) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid rating value.']);
    exit;
}

try {
    // Verify that the review belongs to the user
    $stmt = $pdo->prepare("SELECT id FROM reviews WHERE id = ? AND user_id = ?");
    $stmt->execute([$reviewId, $userId]);
    $review = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$review) {
        echo json_encode(['status' => 'error', 'message' => 'Review not found or access denied.']);
        exit;
    }

    // Update the review
    $updateStmt = $pdo->prepare("UPDATE reviews SET rating = ?, comment = ?, updated_at = GETDATE() WHERE id = ?");
    $updateStmt->execute([$rating, $comment, $reviewId]);

    // Fetch the updated review
    $stmt = $pdo->prepare("SELECT id, rating, comment FROM reviews WHERE id = ?");
    $stmt->execute([$reviewId]);
    $updatedReview = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'message' => 'Review updated successfully.', 'data' => $updatedReview]);
    exit;
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . htmlspecialchars($e->getMessage())]);
    exit;
}
?>
