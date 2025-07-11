<?php
// upo-ui-starter/migrate.php - Root-level wrapper to run migrations

require_once __DIR__ . '/api/database/connection.php'; // Loads env and PDO
require_once __DIR__ . '/api/core/Migrator.php'; // Loads the Migrator class

// Run the migrations
Migrator::run();
?> 