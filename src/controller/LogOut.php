<?php

if (isset($_SESSION['creds'])) {
    session_unset();
}

header('Location: /login');