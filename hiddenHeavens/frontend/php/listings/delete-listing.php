<?php
// php/listings/delete-listing.php

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
    echo json_encode(['status' => 'error', 'message' => 'Listing ID is required.']);
    exit;
}

$listingId = $_POST['id'];

// Verify that the listing belongs to the user
try {
    $stmt = $pdo->prepare("SELECT id FROM listings WHERE id = ? AND user_id = ?");
    $stmt->execute([$listingId, $userId]);
    $listing = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$listing) {
        echo json_encode(['status' => 'error', 'message' => 'Listing not found or access denied.']);
        exit;
    }

    // Delete the listing
    $deleteStmt = $pdo->prepare("DELETE FROM listings WHERE id = ?");
    $deleteStmt->execute([$listingId]);

    echo json_encode(['status' => 'success', 'message' => 'Listing deleted successfully.']);
    exit;
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . htmlspecialchars($e->getMessage())]);
    exit;
}
?>
