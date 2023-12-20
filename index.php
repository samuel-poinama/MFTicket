<?php

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/model/User.php';

// assets router
include __DIR__ . '/src/controller/AssetsRouter.php';

$dotenv = DotenvVault\DotenvVault::createImmutable(__DIR__ . '/.');
$dotenv->safeLoad();
session_start();

// check token

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $user->getUserByToken();
    var_dump($user);
}

// top Bar
include_once __DIR__ . '/src/view/TopBar.php';

// router
include __DIR__ . '/src/controller/Router.php';



