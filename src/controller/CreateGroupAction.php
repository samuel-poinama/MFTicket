<?php
require_once __DIR__ . '/../model/Groups.php';


if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /404');
    exit();
}

if (!isset($_SESSION['user']) || !$_SESSION['user']->getGroup()->isAdmin()) {
    header("Location: /");
    exit();
}


$name = $_POST['name'];


if ($name == null || preg_match('/[^a-zA-Z0-9_ -]/', $name)) {
    header('Location: /admin?error=invalidName');
    exit();
}

$result = Group::createGroup($name);
if (!$result) {
    header('Location: /admin?error=groupExists');
    exit();
}

header('Location: /admin');

