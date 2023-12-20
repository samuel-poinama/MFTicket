<?php
    if (isset($_SESSION['user'])) {
        header('Location: /admin');
        exit();
    }


    if (!isset($_GET['error'])) {
        $_GET['error'] = null;
    }
    
    $error = null;

    switch ($_GET['error']) {
        case 'empty':
            $error = 'Email or password is empty';
            break;
        case 'email':
            $error = 'Invalid email';
            break;
        case 'creds':
            $error = 'Email or password is incorrect';
            break;
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="/assets/css/login.css" rel="stylesheet">
</head>
<body>
    <form action="loginAction" method="post" id="login" >
        <?php if ($error) { ?>
            <div id="error" >
                <strong><?php echo $error ?></strong>
            </div>
        <?php } ?>
        <p>email:</p>
        <input type="text" name="email" >
        <p>password:</p>
        <input type="password" name="password" >
        <input type="submit" value="Login">
    </form>
</body>
</html>