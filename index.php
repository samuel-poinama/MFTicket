<?php

require __DIR__ . '/vendor/autoload.php';

$dotenv = DotenvVault\DotenvVault::createImmutable(__DIR__ . '/.');
$dotenv->safeLoad();

// router
include __DIR__ . '/src/controller/Router.php';

