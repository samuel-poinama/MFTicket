<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="/assets/css/style.css" rel="stylesheet">
    <link href="/assets/css/login.css" rel="stylesheet">
</head>
<body>
    <?php
        include(__DIR__ . '/TopBar.php');
    ?>
    <form action="" method="post" id="login" >
        <p>email:</p>
        <input type="text">
        <p>password:</p>
        <input type="password">
        <input type="submit" value="Login">
    </form>
</body>
</html>