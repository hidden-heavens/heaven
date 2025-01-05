<?php
// php/bookmarks/add-bookmark.php

header('Content-Type: application/json');
session_start();
require '../db.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// Check if the user is logged in
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

// Get and validate the listing ID
$listingId = filter_input(INPUT_POST, 'listing_id', FILTER_VALIDATE_INT);
if (!$listingId) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid Listing ID.']);
    exit;
}

try {
    // Check if the bookmark already exists
    $stmt = $pdo->prepare("SELECT id FROM bookmarks WHERE user_id = ? AND listing_id = ?");
    $stmt->execute([$userId, $listingId]);
    if ($stmt->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'Bookmark already exists.']);
        exit;
    }

    // Insert the bookmark
    $stmt = $pdo->prepare("INSERT INTO bookmarks (user_id, listing_id, created_at) VALUES (?, ?, NOW())");
    $stmt->execute([$userId, $listingId]);

    // Log the action
    $action = "Added bookmark for listing ID $listingId";
    $stmtLog = $pdo->prepare("INSERT INTO audit_logs (user_id, action, timestamp, ip_address) VALUES (?, ?, NOW(), ?)");
    $stmtLog->execute([$userId, $action, $_SERVER['REMOTE_ADDR']]);

    echo json_encode(['status' => 'success', 'message' => 'Bookmark added successfully.']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
