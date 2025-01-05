<?php
require '../db.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $userId = $_SESSION['user_id'];
        $streetAddress = $_POST['street_address'] ?? '';
        $province = $_POST['province'] ?? '';
        $city = $_POST['city'] ?? '';
        $postalCode = $_POST['postal_code'] ?? '';
        $latitude = $_POST['latitude'] ?? null;
        $longitude = $_POST['longitude'] ?? null;

        $stmt = $pdo->prepare("
            INSERT INTO locations (user_id, address, province, city, postal_code, latitude, longitude)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$userId, $streetAddress, $province, $city, $postalCode, $latitude, $longitude]);

        echo json_encode(['status' => 'success', 'message' => 'Location saved successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
