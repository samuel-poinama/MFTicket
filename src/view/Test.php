<?php
            require_once __DIR__ . '/../model/Groups.php';
            require_once __DIR__ . '/../model/User.php';
            /*
            $t = md5(uniqid(mt_rand()));
            $hashedPassword = password_hash("1234", PASSWORD_DEFAULT);
            echo $hashedPassword . "<br>";*/
            echo "<br><br>";

            User::getAllUsersEmailByGroup("admin");


?>