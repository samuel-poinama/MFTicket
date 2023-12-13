<?php

require_once __DIR__ . '/../model/User.php';

// block get requests
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /404');
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

$creds = Credentials::getCredentials($email, $password);

var_dump("ok");
$_SESSION['creds'] = $creds;