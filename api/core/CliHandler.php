<?php
// api/core/CliHandler.php - CLI command handler

class CliHandler {
    public static function handle() {
        global $argv;
        
        if (!isset($argv[1])) {
            return false; // Not a CLI command
        }
        
        // Load database connection first
        require_once __DIR__ . '/../database/connection.php';
        
        // Ensure $pdo is available globally
        global $pdo;
        if (!$pdo) {
            die("Database connection failed\n");
        }
        
        switch ($argv[1]) {
            case '--migrate':
                require_once __DIR__ . '/Migrator.php';
                Migrator::run();
                exit();
                
            case '--seed':
                require_once __DIR__ . '/Seeder.php';
                Seeder::run();
                exit();
                
            case '--migrate:seed':
                require_once __DIR__ . '/Migrator.php';
                require_once __DIR__ . '/Seeder.php';
                Migrator::run();
                Seeder::run();
                exit();
        }
        
        return false; // Not a recognized CLI command
    }
}
?> 