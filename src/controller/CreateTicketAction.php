<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /404');
    exit();
}


if (!isset($_SESSION['user'])) {
    header("Location: /");
    exit();
}


$name = $_POST['name'];

if ($name == null) {
    header('Location: /panel');
    exit();
}

// regex
if (!preg_match('/^[a-zA-Z0-9]+$/', $name)) {
    header('Location: /panel');
    exit();
}


$result = Ticket::createTicket($name);

if (!$result) {
    header('Location: /panel?error=groupExists');
    exit();
}

header('Location: /panel');
