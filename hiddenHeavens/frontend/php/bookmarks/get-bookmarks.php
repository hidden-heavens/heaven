<?php
// php/bookmarks/get-bookmarks.php

header('Content-Type: application/json');
session_start();
require '../db.php';

// Check if the user is logged in
$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT listings.*, categories.name AS category_name
        FROM bookmarks
        JOIN listings ON bookmarks.listing_id = listings.id
        JOIN categories ON listings.category = categories.id
        WHERE bookmarks.user_id = ?
        ORDER BY bookmarks.created_at DESC
    ");
    $stmt->execute([$userId]);
    $bookmarks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'bookmarks' => $bookmarks]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
