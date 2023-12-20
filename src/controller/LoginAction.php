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
if (!isset($email) || !isset($password)) {
    header('Location: /login');
    exit();
}

// check if email is valid
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: /login');
    exit();
}

$user = User::getUser($email, $password);

$_SESSION['user'] = $user;

header('Location: /admin');