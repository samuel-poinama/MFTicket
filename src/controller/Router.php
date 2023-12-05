<?php

// Route the request to the right place
$parsed_url = parse_url($_SERVER['REQUEST_URI']);

// make images, css work
if (preg_match('/\.(png|jpg|jpeg|css)$/', $parsed_url['path'])) {
    $assetPath = __DIR__ . '/../' . $parsed_url['path'];

    if (file_exists($assetPath)) {
        $mime_type = mime_content_type($assetPath);
        if (pathinfo($assetPath, PATHINFO_EXTENSION) === 'css') {
            $mime_type = 'text/css';
        }
        header("Content-Type: $mime_type");
        readfile($assetPath);
        exit();
    } else {
        header('Location: /404');
        exit();
    }
}

// remove .php from the end of the path
$path = preg_replace('/\.php$/', '', $parsed_url['path']);

// redirect /index to /
if ($path == '/index') {
    header('Location: /');
    exit();
}

// Route the request to the right place
if ($path == '/') {
    require __DIR__ . '/../view/Main.php';
} else if ($path == '/login') {
    require __DIR__ . '/../view/Login.php';
} else if ($path == '/LoginAction') {
    require_once __DIR__ . '/../controller/LoginAction.php';
} else if ($path == '/404') {
    require_once __DIR__ . '/../controller/ErrorRequest.php';
    echo errorResponse(404);
} else {
    header('Location: /404');
    exit();
}