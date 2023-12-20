<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /404');
    exit();
}


if (!isset($_SESSION['user']) || !$_SESSION['user']->getGroup()->isAdmin()) {
    header("Location: /");
    exit();
}


$email = $_POST['email'];

if ($email == null) {
    header('Location: /admin?error=invalidCredentials');
    exit();
}


$result = User::deleteUser($email);

if (!$result) {
    header('Location: /admin?error=invalidCredentials');
    exit();
}

header('Location: /admin');