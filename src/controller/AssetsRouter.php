<?php

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