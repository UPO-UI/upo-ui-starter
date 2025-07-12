<?php
// api/index.php - API entry point

require_once __DIR__ . '/database/connection.php';
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/core/CorsHandler.php';
require_once __DIR__ . '/routes/routes.php';

// Initialize CORS handler
$cors = new CorsHandler();

// Set CORS headers
$cors->setHeaders();

// Handle preflight OPTIONS request
$cors->handlePreflight();

// Set content type
header('Content-Type: application/json');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim(str_replace('/api', '', $uri), '/'); // Strip /api prefix
$method = $_SERVER['REQUEST_METHOD'];

Router::dispatch('/' . $uri, $method, $pdo);
?> 