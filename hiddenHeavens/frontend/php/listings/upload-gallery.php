<?php
require '../db.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $listingId = $_POST['listing_id'] ?? null;

    if ($listingId && is_numeric($listingId)) {
        $targetDir = '../uploads/gallery/';
        $filename = basename($_FILES['file']['name']);
        $targetFile = $targetDir . $filename;

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            $stmt = $pdo->prepare("INSERT INTO gallery (listing_id, image_url) VALUES (?, ?)");
            $stmt->execute([$listingId, $targetFile]);

            echo json_encode(['status' => 'success', 'file_path' => $targetFile]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File upload failed.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid listing ID.']);
    }
}

?>
