<?php
// api/core/Seeder.php - Core seeder runner

class Seeder {
    public static function run() {
        global $pdo;
        
        // Check for command arguments
        global $argv;
        $command = isset($argv[2]) ? $argv[2] : 'seed';
        
        switch ($command) {
            case 'status':
                self::status();
                break;
            case 'seed':
            default:
                self::executeSeeders();
                break;
        }
    }
    
    private static function executeSeeders() {
        global $pdo;

        // Create seeders tracking table
        try {
            $pdo->exec('CREATE TABLE IF NOT EXISTS seeders (id INT AUTO_INCREMENT PRIMARY KEY, seeder VARCHAR(255) UNIQUE, executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)');
            self::logSeeder('Seeders tracking table ready.');
        } catch (PDOException $e) {
            self::logSeeder('Error setting up seeders table: ' . $e->getMessage());
            die();
        }

        // Run PHP seeders
        $seederDir = __DIR__ . '/../database/seeders/';
        $phpFiles = glob($seederDir . '*_*.php');
        usort($phpFiles, function($a, $b) { return strcmp(basename($a), basename($b)); }); // Sort by timestamp in filename
        
        foreach ($phpFiles as $file) {
            $seederName = basename($file, '.php');
            // Check if already seeded
            $stmt = $pdo->prepare('SELECT * FROM seeders WHERE seeder = ?');
            $stmt->execute([$seederName]);
            if ($stmt->fetch()) {
                self::logSeeder('Skipping already seeded: ' . $seederName);
                continue;
            }

            require_once $file;
            $class = 'Seeder_' . str_replace(['_', '.php'], ['', ''], basename($file));
            $seeder = new $class($pdo);
            try {
                $seeder->run();
                $trackStmt = $pdo->prepare('INSERT INTO seeders (seeder) VALUES (?)');
                $trackStmt->execute([$seederName]);
                self::logSeeder('Seeder completed: ' . $seederName);
            } catch (Exception $e) {
                self::logSeeder('Error running seeder ' . $seederName . ': ' . $e->getMessage());
            }
        }
    }

    public static function status() {
        global $pdo;
        
        try {
            // Check if seeders table exists
            $pdo->exec('CREATE TABLE IF NOT EXISTS seeders (id INT AUTO_INCREMENT PRIMARY KEY, seeder VARCHAR(255) UNIQUE, executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)');
            
            // Get all seeder files
            $seederDir = __DIR__ . '/../database/seeders/';
            $phpFiles = glob($seederDir . '*_*.php');
            usort($phpFiles, function($a, $b) { return strcmp(basename($a), basename($b)); });
            
            // Get executed seeders
            $executedSeeders = $pdo->query('SELECT seeder, executed_at FROM seeders ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
            $executedSeederNames = array_column($executedSeeders, 'seeder');
            
            echo "\n=== Seeder Status ===\n";
            echo str_pad("Seeder", 50) . str_pad("Status", 15) . "Executed At\n";
            echo str_repeat("-", 80) . "\n";
            
            foreach ($phpFiles as $file) {
                $seederName = basename($file, '.php');
                $status = in_array($seederName, $executedSeederNames) ? '✓ Ran' : '✗ Pending';
                $executedAt = '';
                
                if (in_array($seederName, $executedSeederNames)) {
                    foreach ($executedSeeders as $executed) {
                        if ($executed['seeder'] === $seederName) {
                            $executedAt = $executed['executed_at'];
                            break;
                        }
                    }
                }
                
                echo str_pad($seederName, 50) . 
                     str_pad($status, 15) . 
                     $executedAt . "\n";
            }
            
            // Summary
            $totalSeeders = count($phpFiles);
            $ranSeeders = count($executedSeederNames);
            $pendingSeeders = $totalSeeders - $ranSeeders;
            
            echo "\n=== Summary ===\n";
            echo "Total seeders: $totalSeeders\n";
            echo "Ran: $ranSeeders\n";
            echo "Pending: $pendingSeeders\n";
            
            if ($pendingSeeders > 0) {
                echo "\nTo run pending seeders: php index.php --seed\n";
            }
            
        } catch (Exception $e) {
            echo "Error checking seeder status: " . $e->getMessage() . "\n";
        }
    }

    private static function logSeeder($message) {
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
?> 