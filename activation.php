<?php
require_once 'models/User.php';
require_once 'config/db.php';
require_once 'activation_user.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение почты</title>
</head>
<body>
    <div class="active_content">
        <h1>Активация почты</h1>
        <?php
            if (isset($_GET['idU'])){
                $user = $_GET['idU'];
            }
        ?>
        <form class="" action="activation_user.php" method="post">
            <label for="">Для активации аккаунта нажмите кнопку ниже.</label>
            <?php
                $_SESSION['act_user'] = $user;
            ?>
            <button class="">Активировать</button>
        </form>
    </div>
</body>
</html>