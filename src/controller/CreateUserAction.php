<?php
require_once __DIR__ . '/../model/User.php';


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /404');
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];

if ($email == null || $password == null) {
    header('Location: /admin?error=invalidCredentials');
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: /admin?error=invalidCredentials');
    exit();
}

if (preg_match('/[^a-zA-Z0-9_@.]/', $password)) {
    header('Location: /admin?error=invalidCredentials');
    exit();
}

$hash = password_hash($password, PASSWORD_DEFAULT);
$result = User::createUser($email, $hash);

if (!$result) {
    header('Location: /admin?error=invalidCredentials');
    exit();
}

header('Location: /admin');