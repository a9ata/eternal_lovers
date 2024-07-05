<?php
require_once '../models/User.php';
require_once __DIR__ . '/../config/db.php';

session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Создаем экземпляр класса User
    $user = new User();

    // Вызываем метод login объекта класса User
    if ($user->login($username, $password)) {
        // Авторизация успешна, устанавливаем сессию
        $_SESSION['username'] = $username;
        // Перенаправляем на главную страницу
        header("Location: index.html");
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
    <title>Вход</title>
    <link rel="stylesheet" href="">
</head>
<body>
<div class="login-form">
    <h2>Вход</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Почта: <input type="email" name="email" required><br>
        Пароль: <input type="password" name="password" required><br>
        <input type="submit" value="Войти">
  Submit
</button>
    </form>
    <?php if ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
</div>
<script src="recaptcha.js"></script>
</body>
</html>
