<?php
$parsed_url = parse_url($_SERVER['REQUEST_URI']);

// remove .php from the end of the path
$path = preg_replace('/\.php$/', '', $parsed_url['path']);

// remove / from the beginning of the path
$path = preg_replace('/^\//', '', $path);

$title = 'MF Ticket';

if ($path == 'login') {
    $title = 'Login';
} else if ($path == 'register') {
    $title = 'Register';
} else if ($path == '404') {
    exit();
}

?>


<div>
    <link rel="stylesheet" href="/assets/css/topBar.css">
    <nav id="top_bar">
        <a><img src="/assets/img/logo.jpg" alt="logo" width="64" /></a>
        <h1><?php echo $title ?></h1>
        <a href="/"><img src="/assets/img/cancel.png" width="32" /></a>
    </nav>
</div>