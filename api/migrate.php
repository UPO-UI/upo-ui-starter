<?php
// api/migrate.php - Run all database migrations from terminal

require_once __DIR__ . '/database/connection.php'; // Loads env from project root and connects to DB

$migrationDir = __DIR__ . '/database/migrations/';
$files = glob($migrationDir . '*.sql');

if (empty($files)) {
    echo "No migration files found.\n";
    exit;
}

foreach ($files as $file) {
    $sql = file_get_contents($file);
    try {
        $pdo->exec($sql);
        echo "Successfully ran migration: " . basename($file) . "\n";
    } catch (PDOException $e) {
        echo "Error running " . basename($file) . ": " . $e->getMessage() . "\n";
    }
}

echo "All migrations completed.\n";
?> 