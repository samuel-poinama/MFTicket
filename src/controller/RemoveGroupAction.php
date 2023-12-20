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

$group = $_POST['group'];

if ($group == null) {
    header('Location: /admin');
    exit();
}

// regex
if (!preg_match('/^[a-zA-Z0-9]+$/', $group)) {
    header('Location: /admin');
    exit();
}


$result = Group::deleteGroup($group);
if (!$result) {
    header('Location: /admin?error=canNotDeleteGroup');
    exit();
}


header('Location: /admin');