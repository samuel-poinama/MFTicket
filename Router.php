<?php


// Route the request to the right place
// This is the router

$parsed_url = parse_url($_SERVER['REQUEST_URI']);

// remove .php from the end of the path
$path = preg_replace('/\.php$/', '', $parsed_url['path']);

// redirect /index to /
if ($path == '/index') {
    header('Location: /');
    exit();
}


// Route the request to the right place
if ($path == '/') {
    require __DIR__ . '/view/index.php';
} else {
    require_once(__DIR__ . '/controller/ErrorRequest.php');
    echo errorResponse(404);
}