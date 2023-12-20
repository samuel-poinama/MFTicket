<?php


if (isset($_SESSION['user'])) {
    header('Location: /admin');
    exit();
} else {
    header('Location: /login');
    exit();
}