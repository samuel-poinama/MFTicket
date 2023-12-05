<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MFTicket</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <h1>
        <?php
            require_once __DIR__ . '/../model/DataBaseConnection.php';

            $db = new DataBaseConnection();
            
            
            //$db->execute("INSERT INTO users (email, password) VALUES ('email@email.email', 'email')");
            $result = $db->query("SELECT * FROM users");
            foreach ($result as $row) {
                var_dump($row);
            }
        ?>
    </h1>
</body>
</html>