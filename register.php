<?php
require_once 'config/db.php';
session_start();

// Если пользователь уже вошел, перенаправить на главную
if (isset($_SESSION['name'])) {
    header("Location: index.php");
    exit;
}

$error = ''; // Переменная для сохранения сообщений об ошибках

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Проверка пароля
    if (strlen($password) < 8 || !preg_match("/[a-zA-Z]/", $password) || !preg_match("/\d/", $password) || !preg_match("/\W/", $password)) {
        $error = 'Пароль должен содержать минимум 8 символов, включать буквы, цифры и специальные символы.';
    } elseif ($password !== $confirm_password) {
        $error = 'Пароли не совпадают.';
    } else {
        // Проверка на существование пользователя с таким email или телефоном
        $checkUser = $conn->prepare("SELECT * FROM user WHERE email = ? OR telephone = ?");
        $checkUser->bind_param("ss", $email, $telephone);
        $checkUser->execute();
        $result = $checkUser->get_result();

        if ($result->num_rows > 0) {
            $error = "Пользователь с таким email или телефоном уже существует.";
        } else {
            // Хэшируем пароль
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Попытка регистрации
            $stmt = $conn->prepare("INSERT INTO user (name, email, telephone, password, access, accessmail, 2fa_enabled) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if ($stmt === false) {
                die('Prepare failed: ' . $conn->error);
            }

            $access = 0; // Значение по умолчанию для обычного пользователя
            $accessmail = 0; // Значение по умолчанию для неактивированного через почту пользователя
            $fa_enabled = 0; // Значение по умолчанию для 2FA

            $stmt->bind_param("ssssiii", $name, $email, $telephone, $hashed_password, $access, $accessmail, $fa_enabled);

            // Проверяем, успешно ли выполнен запрос
            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $error = 'Ошибка при регистрации. Пожалуйста, попробуйте снова.';
            }
            $stmt->close();
        }
        $checkUser->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en,ru">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="public/logo_E&L_title.svg" width="auto">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&family=Lavishly+Yours&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>
<header class="header">
      <div class="header__container">
        <div class="header__logo">
          <a href="index.php"><img src="public/logo_E&L_title.svg" alt="Eternal Lovers" width="57.49px"></a>
        </div>
        <nav class="header__nav">
          <ul class="nav__list">
            <li class="nav__item"><a href="catalog.php" class="nav__link">Каталог</a></li>
            <li class="nav__item"><a href="index.php#about" class="nav__link">О нас</a></li>
            <li class="nav__item"><a href="index.php#consultation" class="nav__link">Консультация</a></li>
            <li class="nav__item"><a href="index.php#services" class="nav__link">Услуги</a></li>
            <li class="nav__item"><a href="blog.php" class="nav__link">Блог</a></li>
            <li class="nav__item"><a href="portfolio.php" class="nav__link">Портфолио</a></li>
            <li class="nav__item"><a href="reviews.php" class="nav__link">Отзывы</a></li>
          </ul>
        </nav>
        <div class="header__icons">
          <a href="contact.php" class="header__icon"><img src="public/icon/hugeicons_contact.svg" alt="Contact"></a>
          <a href="basket.php" class="header__icon"><img src="public/icon/ph_basket-thin.svg" alt="Basket"></a>
          <?php if (isset($_SESSION['name'])): ?>
            <a href="profile.php" class="header__icon">
              <img src="public/icon/iconamoon_profile-light.svg" alt="Profile">
              <?php echo $_SESSION['name'] ?>
            </a>
          <?php endif; ?>
        </div>
        <div class="header__btn">
          <div class="menu-btn">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>
        <nav class="header__menu-burger">
            <li><a href="catalog.php" class="nav__link">Каталог</a></li>
            <li><a href="index.php#about" class="nav__link">О нас</a></li>
            <li><a href="index.php#consultation" class="nav__link">Консультация</a></li>
            <li><a href="index.php#services" class="nav__link">Услуги</a></li>
            <li><a href="blog.php" class="nav__link">Блог</a></li>
            <li><a href="portfolio.php" class="nav__link">Портфолио</a></li>
            <li><a href="reviews.php" class="nav__link">Отзывы</a></li>
        </nav>
      </div>
</header>
<div class="register-form">
    <h2>Регистрация</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="name" placeholder="Имя" required><br>
        <input type="email" name="email" placeholder="Почта" required><br>
        <input type="text" name="telephone" id="telephone" placeholder="Телефон" required><br>
        <input type="password" name="password" placeholder="Пароль" required><br>
        <input type="password" name="confirm_password" placeholder="Подтвердите пароль" required><br>
        <input type="submit" value="Зарегистрироваться">
    </form>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
</div>
<script>
    // Функция для создания маски телефона
    document.getElementById('telephone').addEventListener('input', function (e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{1})(\d{3})(\d{3})(\d{4})/);
        e.target.value = x ? '8(' + x[2] + ')' + x[3] + '-' + x[4] : e.target.value.slice(0, 15);
    });
</script>
</body>
</html>