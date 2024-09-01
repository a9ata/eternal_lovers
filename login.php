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
    $access = $user->login($email, $password);
    if ($access !== false) {
        // Авторизация успешна, перенаправляем на соответствующую страницу
        $_SESSION['username'] = $email;
        $_SESSION['is_admin'] = $access == 1;

        if ($_SESSION['is_admin']) {
            header("Location: admin.php");
        } else {
            header("Location: profile.php");
        }
        exit;
    } else {
        $error = 'Неверное имя пользователя или пароль.';
    }
}

// Обработка reCAPTCHA (остается как есть)
$secret = '6LcC6iAqAAAAAIGVh_HoytOXnU9imh0af-yvaMmU';

if (!empty($_POST['g-recaptcha-response'])) {
    $curl = curl_init('https://www.google.com/recaptcha/api/siteverify');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, 'secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $out = curl_exec($curl);
    curl_close($curl);

    $out = json_decode($out);
    if ($out->success == true) {
        $error = false;
    }
}

if ($error) {
    echo 'Ошибка заполнения капчи.';
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <link rel="icon" type="image/svg+xml" href="public/logo_E&L_title.svg" width="auto" />
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&family=Lavishly+Yours&display=swap" rel="stylesheet" />
    <title>Вход</title>
</head>
<body>
<header class="header">
      <div class="header__container">
        <div class="header__logo">
            <a href="index.php" class="nav__link">
                <img src="public/logo_E&L_title.svg" alt="Eternal Lovers" width="57.49px">
            </a>
        </div>
        <nav class="header__nav">
          <ul class="nav__list">
            <li class="nav__item"><a href="catalog.php" class="nav__link">Каталог</a></li>
            <li class="nav__item"><a href="#about" class="nav__link">О нас</a></li>
            <li class="nav__item"><a href="#consultation" class="nav__link">Консультация</a></li>
            <li class="nav__item"><a href="#services" class="nav__link">Услуги</a></li>
            <li class="nav__item"><a href="blog.php" class="nav__link">Блог</a></li>
            <li class="nav__item"><a href="portfolio.php" class="nav__link">Портфолио</a></li>
            <li class="nav__item"><a href="reviews.php" class="nav__link">Отзывы</a></li>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
              <li class="nav__item"><a href="admin.php" class="nav__link">Админ-панель</a></li>
            <?php endif; ?>
          </ul>
        </nav>
        <div class="header__icons">
          <a href="contact.php" class="header__icon"><img src="public/icon/hugeicons_contact.svg" alt="Contact"></a>
          <a href="favorite.php" class="header__icon"><img src="public/icon/ph_heart-thin.svg" alt="Favorite"></a>
          <a href="basket.php" class="header__icon"><img src="public/icon/ph_basket-thin.svg" alt="Basket"></a>
          <a href="profile.php" class="header__icon">
            <img src="public/icon/iconamoon_profile-light.svg" alt="Profile">
            <?php if (isset($_SESSION['name'])): ?>
                <?php echo htmlspecialchars($_SESSION['name']); ?>
            <?php endif; ?>
          </a>
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
            <li><a href="#about" class="nav__link">О нас</a></li>
            <li><a href="#consultation" class="nav__link">Консультация</a></li>
            <li><a href="#services" class="nav__link">Услуги</a></li>
            <li><a href="blog.php" class="nav__link">Блог</a></li>
            <li><a href="portfolio.php" class="nav__link">Портфолио</a></li>
            <li><a href="reviews.php" class="nav__link">Отзывы</a></li>
        </nav>
      </div>
    </header>
    <div class="login-form">
        <h2>Вход</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="email" name="email" placeholder="Почта" required><br>
            <input type="password" name="password" placeholder="Пароль" required><br>
            <input type="submit" value="Войти">
            <div class="g-recaptcha" data-sitekey="6LcC6iAqAAAAACrp7sBowBzOobk-O8_ajOcItXPP"></div>
        </form>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
    </div>

    <script>
    function onClick(e) {
        e.preventDefault();
        grecaptcha.enterprise.ready(async () => {
            const token = await grecaptcha.enterprise.execute('6LcC6iAqAAAAAIGVh_HoytOXnU9imh0af-yvaMmU', {action: 'LOGIN'});
        });
    }
    </script>

</body>
</html>
