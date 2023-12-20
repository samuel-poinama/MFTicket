<?php
require_once __DIR__ . '/../model/Groups.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: /404');
    exit();
}

$data = $_POST['group'];


if ($data == null) {
    header('Location: /admin');
    exit();
}

$data = explode('_', $data);

$id = $data[0];


if ($id == null || preg_match('/[^0-9]/', $id)) {
    header('Location: /admin');
    exit();
}


$name = $data[1];

if ($name == null || preg_match('/[^a-zA-Z0-9_ -]/', $name)) {
    header('Location: /admin');
    exit();
}

$result = User::changeGroup($id, $name);

if ($result) {
    header('Location: /admin');
    exit();
} else {
    header('Location: /admin?error=groupDoesNotExist');
    exit();
}