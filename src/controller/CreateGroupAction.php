<?php
require_once __DIR__ . '/../model/Groups.php';


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /404');
    exit();
}


$name = $_POST['name'];


if ($name == null || preg_match('/[^a-zA-Z0-9_ -]/', $name)) {
    header('Location: /admin');
    exit();
}

Group::createGroup($name);

header('Location: /admin');

