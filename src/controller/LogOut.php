<?php

if (isset($_SESSION['user'])) {
    session_unset();
}

header('Location: /login');