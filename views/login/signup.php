<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/login.css">
    <link rel="icon" type="image/png" href=" <?php echo constant('URL'); ?>public/img/icons/expenses.ico">
    <title>Registrarse</title>
</head>
<body>
    <?php require 'views/header.php'; ?>
    <?php $this->showMessages();?>
    <div id="login-main">
    
        <form action="<?php echo constant('URL'); ?>signup/newUser" method="POST">
        <div></div>
        <div class="title-signup fcenterf">
            <h2>.::Registrarse::.</h2>
            </div>
            <div class="logo-expenses fcenterf">
                <img src=" <?php echo constant('URL'); ?>public/img/expenses.png" />
        </div>
            

            <p>
                <label for="username">Username</label>
                <input type="text" name="username" id="username">
            </p>
            <p>
                <label for="password">password</label>
                <input type="text" name="password" id="password">
            </p>
            <div class="fcenterf">
                <input type="submit" value="Iniciar sesión" />
            </div>
            <div class="yes-acount fcenterf">
                ¿Tienes una cuenta? <a href="<?php echo constant('URL'); ?>">Iniciar sesion</a>
            </div>
        </form>
    </div>
</body>
</html>