<?php
// api/index.php - API entry point

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Adjust for security in production
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once __DIR__ . '/database/connection.php';
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/routes/routes.php';

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim(str_replace('/api', '', $uri), '/'); // Strip /api prefix
$method = $_SERVER['REQUEST_METHOD'];

Router::dispatch('/' . $uri, $method, $pdo);
?> 