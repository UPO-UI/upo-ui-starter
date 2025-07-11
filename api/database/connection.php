<?php
// api/database/connection.php - Reusable DB connection

require_once __DIR__ . '/../config/load_env.php'; // Load env helper
$env = loadEnv(__DIR__ . '/../../.env'); // Path to project root .env

$host = $env['DB_HOST'] ?? 'localhost';
$db = $env['DB_NAME'] ?? 'upoui_db';
$user = $env['DB_USER'] ?? 'root';
$pass = $env['DB_PASS'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['error' => 'DB Connection failed: ' . $e->getMessage()]));
}
?> 