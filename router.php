<?php
// upo-ui-starter/router.php - Local router for PHP built-in server

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// If path starts with /api/, route to API entry point
if (strpos($uri, '/api/') === 0) {
    $_SERVER['REQUEST_URI'] = substr($uri, 4); // Strip /api/ for the API dispatcher
    include __DIR__ . '/api/public/index.php';
    exit;
}

// Serve real files (e.g., JS, CSS, images) if they exist
$requestPath = __DIR__ . $uri;
if (file_exists($requestPath) && !is_dir($requestPath)) {
    return false;
}

// Fallback to frontend index.php (or index.html if static)
include __DIR__ . '/index.php';
?> 