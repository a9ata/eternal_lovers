<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/svg+xml" href="public/logo_E&L_title.svg" width="auto" />
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&family=Lavishly+Yours&display=swap" rel="stylesheet" />
    <title>Профиль</title>
</head>
<body>
    <div class="profile">
        <h2>Профиль</h2>
        <div class="profile__user-data">
            <?php if (isset($_SESSION['name'], $_SESSION['email'], $_SESSION['telephone'])): ?>
            <p class="profile__name"><?php echo htmlspecialchars($_SESSION['name']); ?></p><br />
            <p class="profile__email"><?php echo htmlspecialchars($_SESSION['email']); ?></p><br />
            <p class="profile__tel"><?php echo htmlspecialchars($_SESSION['telephone']); ?></p>   
        </div>
        <a href="logout.php">Выйти</a>
        <div class="profile__log">
            <?php else: ?>
            <a href="login.php">Вход</a> 
            <a href="register.php">Регистрация</a>
            <?php endif; ?>
        </div>   
    </div>
</body>
</html>