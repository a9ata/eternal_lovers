<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link rel="icon" type="image/svg+xml" href="public/logo_E&L_title.svg" width="auto"/>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&family=Lavishly+Yours&display=swap" rel="stylesheet">
    <title>Профиль</title>
</head>
<body>
<?php if (isset($_SESSION['username'])): ?>
    <p>Привет, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <a href="logout.php">Выйти</a>
<?php else: ?>
    <a href="login.php">Вход</a> |
    <a href="register.php">Регистрация</a>
<?php endif; ?>
</body>
</html>