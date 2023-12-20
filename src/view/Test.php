<?php
            require_once __DIR__ . '/../model/Groups.php';
            require_once __DIR__ . '/../model/User.php';
            require_once __DIR__ . '/../model/Tasks.php';
            
            $t = md5(uniqid(mt_rand()));
            $hashedPassword = password_hash("1234", PASSWORD_BCRYPT);
            echo $hashedPassword . "<br>";
            echo "<br><br>";

            var_dump(Ticket::getAllTickets());


?>