<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MFTicket</title>
</head>
<body>
    <h1>
        <?php
            require_once __DIR__ . '/../model/DataBaseConnection.php';

            $db = new DataBaseConnection();
            
            
            //$db->execute("INSERT INTO users (email, password) VALUES ('email@email.email', 'email')");
            $result = $db->query("SELECT * FROM credentials");
            foreach ($result as $row) {
                var_dump($row);
            }

            var_dump($_SESSION);
        ?>
    </h1>
</body>
</html>