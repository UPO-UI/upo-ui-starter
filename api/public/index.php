<?php
// api/public/index.php - API Entry Point

require_once __DIR__ . '/../database/connection.php'; // Load DB (and env from root)
require_once __DIR__ . '/../routes/routes.php'; // Load defined routes

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/api/');
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

// Dispatch the request using the router
Router::dispatch($path, $method, $pdo);
?> 