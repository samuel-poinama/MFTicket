<?php

require_once __DIR__ . '/../model/User.php';

// block get requests
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /404');
    exit();
}

// check if user are set
if (array_key_exists('user', $_SESSION)) {
    header('Location: /admin');
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];


// check if email and password are set
if (!isset($email) || !isset($password) || empty($email) || empty($password)) {
    header('Location: /login?error=empty');
    exit();
}

// check if email is valid
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: /login?error=email');
    exit();
}

$user = User::getUser($email, $password);
if (!$user) {
    header('Location: /login?error=creds');
    exit();
}

$_SESSION['user'] = $user;

header('Location: /admin');