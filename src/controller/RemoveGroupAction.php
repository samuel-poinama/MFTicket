<?php
require_once __DIR__ . '/../model/Groups.php';

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


Group::deleteGroup($group);

header('Location: /admin');