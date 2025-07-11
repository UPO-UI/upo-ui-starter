<?php
// api/public/index.php - API Entry Point

require_once __DIR__ . '/../database/connection.php'; // Load DB (and env from root)

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/api/');
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

switch ($path) {
    case 'users':
        require_once __DIR__ . '/../controllers/UserController.php';
        handleUsers($method, $pdo);
        break;
    case 'proxy/test':
        // Sample proxy: Fetches from external API using key from .env
        $apiKey = $env['SOME_API_KEY'] ?? 'default-key'; // Loaded from root .env
        $externalUrl = 'https://jsonplaceholder.typicode.com/posts/1'; // Test URL
        $ch = curl_init($externalUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $apiKey"]);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response ? $response : json_encode(['error' => 'Proxy failed']);
        break;
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}
?> 