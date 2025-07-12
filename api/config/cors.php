<?php
// api/config/cors.php - CORS configuration

return [
    // Allowed origins (domains that can access the API)
    'allowed_origins' => [
        'http://localhost:8000',
        'http://localhost:3000',
        'http://127.0.0.1:8000',
        'http://127.0.0.1:3000',
        // Add your production domains here
        // 'https://yourdomain.com',
        // 'https://app.yourdomain.com',
    ],
    
    // Allowed HTTP methods
    'allowed_methods' => [
        'GET',
        'POST', 
        'PUT',
        'DELETE',
        'OPTIONS'
    ],
    
    // Allowed headers
    'allowed_headers' => [
        'Content-Type',
        'Authorization',
        'X-Requested-With',
        'X-API-Key',
        'Accept'
    ],
    
    // Exposed headers (headers that browsers can access)
    'exposed_headers' => [
        'X-RateLimit-Remaining',
        'X-RateLimit-Limit'
    ],
    
    // Max age for preflight requests (in seconds)
    'max_age' => 86400, // 24 hours
    
    // Whether to allow credentials (cookies, authorization headers)
    'allow_credentials' => true,
    
    // Default origin if request origin is not in allowed list
    'default_origin' => 'http://localhost:8000'
];
?> 