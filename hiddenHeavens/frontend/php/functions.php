<?php
// php/functions.php

/**
 * Retrieves the username based on the user ID.
 *
 * @param int $userId
 * @param PDO $pdo
 * @return string
 */
function getUsernameById($userId, $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ? htmlspecialchars($user['username']) : 'Unknown User';
    } catch (PDOException $e) {
        return 'Unknown User';
    }
}
?>
