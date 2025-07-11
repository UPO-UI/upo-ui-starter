<?php
// api/migrate.php - Enhanced migration runner: supports models and SQL files

require_once __DIR__ . '/database/connection.php'; // Loads env and PDO

// Step 1: Create a migrations tracking table if it doesn't exist
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS migrations (id INT AUTO_INCREMENT PRIMARY KEY, migration VARCHAR(255) UNIQUE, executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
    logMigration('Migrations tracking table ready.');
} catch (PDOException $e) {
    logMigration('Error setting up migrations table: ' . $e->getMessage());
    die();
}

function logMigration($message) {
    $logDir = __DIR__ . '/storage/logs/';
    $logFile = $logDir . 'upoui.log';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
    echo "$message\n"; // Also echo to terminal
}

// Step 2: Run model-based migrations (discover all models)
$modelDir = __DIR__ . '/models/';
$models = glob($modelDir . '*Model.php');
foreach ($models as $modelFile) {
    $modelClass = basename($modelFile, '.php');
    if ($modelClass === 'BaseModel') continue; // Skip base class

    require_once $modelFile;
    $migrationName = $modelClass . '_migration';

    // Check if already migrated
    $stmt = $pdo->prepare("SELECT * FROM migrations WHERE migration = ?");
    $stmt->execute([$migrationName]);
    if ($stmt->fetch()) {
        logMigration("Skipping already migrated: $modelClass");
        continue;
    }

    try {
        $modelClass::migrate($pdo);
        // Track as executed
        $trackStmt = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $trackStmt->execute([$migrationName]);
        logMigration("Model migration completed: $modelClass");
    } catch (Exception $e) {
        logMigration("Error migrating $modelClass: " . $e->getMessage());
    }
}

// Step 3: Run any remaining SQL files (for manual migrations)
$migrationDir = __DIR__ . '/database/migrations/';
$files = glob($migrationDir . '*.sql');
if (empty($files)) {
    logMigration('No additional SQL migration files found.');
} else {
    foreach ($files as $file) {
        $migrationName = basename($file);
        // Check if already migrated
        $stmt = $pdo->prepare("SELECT * FROM migrations WHERE migration = ?");
        $stmt->execute([$migrationName]);
        if ($stmt->fetch()) {
            logMigration("Skipping already migrated SQL: $migrationName");
            continue;
        }

        $sql = file_get_contents($file);
        try {
            $pdo->exec($sql);
            // Track as executed
            $trackStmt = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
            $trackStmt->execute([$migrationName]);
            logMigration("Successfully ran SQL migration: $migrationName");
        } catch (PDOException $e) {
            logMigration("Error running $migrationName: " . $e->getMessage());
        }
    }
}

logMigration('All migrations completed.');
?> 