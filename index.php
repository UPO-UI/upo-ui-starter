<?php
// upo-ui-starter/index.php - Single root entry point for both API and frontend

// Load shared dependencies
require_once __DIR__ . '/api/database/connection.php'; // Loads env and PDO
require_once __DIR__ . '/api/core/Router.php'; // Loads the Router class
require_once __DIR__ . '/api/routes/routes.php'; // Loads defined routes

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json'); // Default for API

// Dev-only: Run migrations if ?migrate=1 is set (e.g., visit /?migrate=1)
if (isset($_GET['migrate']) && $_GET['migrate'] === '1') {
    require_once __DIR__ . '/api/core/Migrator.php'; // Loads the Migrator class
    Migrator::run();
    echo '<p style="color: green;">Migrations completed! Refresh without ?migrate=1 to load the app.</p>';
    exit; // Stop here after running migrations
}

// Handle API requests if path starts with 'api/'
if (strpos($uri, 'api/') === 0) {
    $path = substr($uri, 4); // Remove 'api/' prefix
    Router::dispatch($path, $method, $pdo);
    exit; // Stop after API response
}

// Otherwise, render the frontend (set HTML content type)
header('Content-Type: text/html; charset=UTF-8');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>UPO UI</title>
        <link rel="icon" href="/src/app/favicon.ico" type="image/x-icon">
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        <!-- Import Map for @ aliases (loaded from config file) -->
        <script src="/importmap.config.js"></script>
        <!-- Router Outlet -->
        <div id="app">
            <div class="flex items-center justify-center min-h-screen">
                <div class="text-xl">Loading...</div>
            </div>
        </div>

        <!-- Load UPO App -->
        <script type="module" src="/src/main.js"></script>
    </body>
</html> 