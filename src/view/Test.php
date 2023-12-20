<?php
            require_once __DIR__ . '/../model/Groups.php';
            
            $t = md5(uniqid(mt_rand()));
            $hashedPassword = password_hash("4567", PASSWORD_DEFAULT);
            echo $hashedPassword . "<br>";

            var_dump($_SESSION);


?>