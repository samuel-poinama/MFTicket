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
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/topBar.css">
    <nav id="top_bar">
        <a href="/"><img src="/assets/img/logo.jpg" alt="logo" width="64" /></a>
        <h1><?php echo $title ?></h1>
        <?php if (isset($_SESSION['user'])) { ?>
        <a href="/logout"><img src="/assets/img/login_white.png" width="50" /></a>
        <?php } else { ?>
            <a href="/"><img src="/assets/img/close_white.png" width="50" /></a>
        <?php } ?>

    </nav>
</div>