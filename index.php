<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = DotenvVault\DotenvVault::createImmutable(__DIR__ . '/.');
$dotenv->safeLoad();
session_start();

/*
$t = md5(uniqid(mt_rand()));
$hashedPassword = password_hash("1234", PASSWORD_DEFAULT);
var_dump($hashedPassword);
*/

// assets router
include __DIR__ . '/src/controller/AssetsRouter.php';

// top Bar
include_once __DIR__ . '/src/view/TopBar.php';

// router
include __DIR__ . '/src/controller/Router.php';



