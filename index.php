<?php
// upo-ui-starter/index.php - Frontend entry with integrated migration trigger

// Check if CLI mode and --migrate argument is provided
if (php_sapi_name() === 'cli' && isset($argv[1]) && $argv[1] === '--migrate') {
    require_once __DIR__ . '/api/database/connection.php';
    require_once __DIR__ . '/api/core/Migrator.php';
    Migrator::run();
    exit();
}
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