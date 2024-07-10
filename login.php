<?php
require_once 'models/User.php';
require_once 'config/db.php';

session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Создаем экземпляр класса User
    $user = new User();

    // Вызываем метод login объекта класса User
    if ($user->login($email, $password)) {
        // Авторизация успешна, перенаправляем на страницу профиля
        header("Location: profile.php");
        exit;
    } else {
        $error = 'Неверное имя пользователя или пароль.';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/svg+xml" href="public/logo_E&L_title.svg" width="auto" />
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&family=Lavishly+Yours&display=swap" rel="stylesheet" />
    <title>Вход</title>
</head>
<body>
<div class="login-form">
    <h2>Вход</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="email" name="email" placeholder="Почта" required><br>
        <input type="password" name="password" placeholder="Пароль" required><br>
        <input type="submit" value="Войти">
    </form>
    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
</div>
</body>
</html>
