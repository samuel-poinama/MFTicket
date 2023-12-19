<?php
require_once __DIR__ . '/../model/Groups.php';


$name = $_POST['name'];


if ($name == null) {
    header('Location: /admin');
    exit();
}

Group::createGroup($name);

header('Location: /admin');

