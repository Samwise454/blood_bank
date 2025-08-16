<?php
    $allowedOrigins = [
            'https://blood-bank-db.vercel.app',
            // 'https://smarteacher.vercel.app', //reserved for the main link
            'http://localhost:5173'
        ];
        
    $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

    if (in_array($origin, $allowedOrigins)) {
        header("Access-Control-Allow-Origin: " . $origin);
        header("Access-Control-Allow-Credentials: true");
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header("Access-Control-Max-Age: 600");//caching for 10 minutes
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    }
    