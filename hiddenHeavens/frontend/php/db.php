<?php
$serverName = "VIC\SQLEXPRESS"; // Replace with your server name
$database = "hidden_heavens"; // Replace with your database name

try {
    $pdo = new PDO("sqlsrv:server=$serverName;Database=$database", null, null);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Database connection successful using Windows Authentication.";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); // This won't be output if it's caught before sending JSON
}
?>