<?php

// Route the request to the right place
$parsed_url = parse_url($_SERVER['REQUEST_URI']);

// remove .php from the end of the path
$path = preg_replace('/\.php$/', '', $parsed_url['path']);

// redirect /index to /
if ($path == '/index') {
    header('Location: /');
    exit();
}

switch ($path) {
    case '/':
        require __DIR__ . '/../view/Main.php';
        break;
    case '/test':
        require __DIR__ . '/../view/Test.php';
        break;
    case '/login':
        require __DIR__ . '/../view/Login.php';
        break;
    case '/createUser':
        require_once __DIR__ . '/../controller/CreateUserAction.php';
        break;
    case '/deleteUser':
        require_once __DIR__ . '/../controller/DeleteUserAction.php';
        break;
    case '/loginAction':
        require_once __DIR__ . '/../controller/LoginAction.php';
        break;
    case '/logout':
        require_once __DIR__ . '/../controller/LogOut.php';
        break;
    case '/admin':
        require_once __DIR__ . '/../view/Admin.php';
        break;
    case '/editTicket':
        require_once __DIR__ . '/../controller/ChangeGroupAction.php';
        break;
    case '/createGroup':
        require_once __DIR__ . '/../controller/CreateGroupAction.php';
        break;
    case '/removeGroup':
        require_once __DIR__ . '/../controller/RemoveGroupAction.php';
        break;
    case '/404':
        require_once __DIR__ . '/../controller/ErrorRequest.php';
        echo errorResponse(404);
        break;
    default:
        header('Location: /404');
        break;
}