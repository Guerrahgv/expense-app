<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/default.css">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/login.css">
    <link rel="icon" type="image/png" href=" <?php echo constant('URL'); ?>public/img/icons/expenses.ico">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script  src="<?php echo constant('URL'); ?>public/js/appJQ.js" defer></script>

</head>
<body>
    <?php require 'views/header.php'; ?>
    <?php $this->showMessages();?>
    <div id="login-main">
    <div class="title-login fcenterf">
            <h2>.::Login::.</h2>
            </div>
           
        <div class="logo-expenses fcenterf">
                <img src=" <?php echo constant('URL'); ?>public/img/expenses.png" />
        </div>
        <form action="<?php echo constant('URL'); ?>login/authenticate" method="POST">
        <div><?php (isset($this->errorMessage))?  $this->errorMessage : '' ?></div>
           

            <p>
                <label for="username">Username</label>
                <input type="text" name="username" id="username" autocomplete="off">
            </p>
            <p>
                <label for="password">password</label>
                <input type="password" name="password" id="password" autocomplete="off">
            </p>
            <div class="fcenterf">
                <input type="submit" value="Iniciar sesión" />
            </div>

            <div class="not-acount fcenterf" style="margin-top:10px;">
                <pre>¿No tienes cuenta? </pre> <a href="<?php echo constant('URL'); ?>signup">Registrarse</a>
            </div>
        </form>
    </div>
</body>
</html>