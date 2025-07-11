<?php
// api/core/Migrator.php - Core migration runner: supports models and SQL files

require_once __DIR__ . '/../database/connection.php'; // Loads env and PDO

class Migrator {
    public static function run() {
        global $pdo;

        // Existing Step 1: Migrations tracking table
        try {
            $pdo->exec('CREATE TABLE IF NOT EXISTS migrations (id INT AUTO_INCREMENT PRIMARY KEY, migration VARCHAR(255) UNIQUE, batch INT, executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)'); // Added batch for rollback grouping
            self::logMigration('Migrations tracking table ready.');
        } catch (PDOException $e) {
            self::logMigration('Error setting up migrations table: ' . $e->getMessage());
            die();
        }

        // Check if batch column exists and add it if not
        $columnCheck = $pdo->query("SHOW COLUMNS FROM migrations LIKE 'batch'")->rowCount();
        if ($columnCheck == 0) {
            $pdo->exec('ALTER TABLE migrations ADD COLUMN batch INT AFTER migration');
            self::logMigration('Added batch column to migrations table.');
        }

        // New Step: Run PHP migrations
        $migrationDir = __DIR__ . '/../database/migrations/';
        $phpFiles = glob($migrationDir . '*_*.php');
        usort($phpFiles, function($a, $b) { return strcmp(basename($a), basename($b)); }); // Sort by timestamp in filename
        $batch = (int) $pdo->query('SELECT MAX(batch) FROM migrations')->fetchColumn() + 1;
        foreach ($phpFiles as $file) {
            $migrationName = basename($file, '.php');
            // Check if already migrated
            $stmt = $pdo->prepare('SELECT * FROM migrations WHERE migration = ?');
            $stmt->execute([$migrationName]);
            if ($stmt->fetch()) {
                self::logMigration('Skipping already migrated PHP: ' . $migrationName);
                continue;
            }

            require_once $file;
            $class = 'Migration_' . str_replace(['_', '.php'], ['', ''], basename($file));
            $migration = new $class($pdo);
            try {
                $migration->up();
                $trackStmt = $pdo->prepare('INSERT INTO migrations (migration, batch) VALUES (?, ?)');
                $trackStmt->execute([$migrationName, $batch]);
                self::logMigration('PHP migration completed: ' . $migrationName);
            } catch (Exception $e) {
                self::logMigration('Error running PHP migration ' . $migrationName . ': ' . $e->getMessage());
            }
        }

        // Existing model and SQL steps here (unchanged)...
    }

    public static function rollback($steps = 1) {
        global $pdo;
        $lastBatch = $pdo->query('SELECT MAX(batch) FROM migrations')->fetchColumn();
        if (!$lastBatch) {
            self::logMigration('No migrations to rollback.');
            return;
        }
        $migrations = $pdo->query('SELECT migration FROM migrations WHERE batch = ' . $lastBatch . ' ORDER BY id DESC LIMIT ' . $steps)->fetchAll(PDO::FETCH_COLUMN);
        foreach ($migrations as $migrationName) {
            $file = __DIR__ . '/../database/migrations/' . $migrationName . '.php';
            if (!file_exists($file)) continue;
            require_once $file;
            $class = 'Migration_' . str_replace(['_', '.php'], ['', ''], $migrationName);
            $migration = new $class($pdo);
            try {
                $migration->down();
                $pdo->prepare('DELETE FROM migrations WHERE migration = ?')->execute([$migrationName]);
                self::logMigration('Rolled back: ' . $migrationName);
            } catch (Exception $e) {
                self::logMigration('Error rolling back ' . $migrationName . ': ' . $e->getMessage());
            }
        }
    }

    private static function logMigration($message) {
        $logDir = __DIR__ . '/../storage/logs/';
        $logFile = $logDir . 'upoui.log';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
        echo "$message\n"; // Also echo to terminal
    }
}

// Run the migrator
?> 