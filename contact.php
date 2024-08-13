<?php
session_start();
require_once 'config/db.php';

$error = '';
$success = '';

// Получение данных пользователя из сессии
$user_data = [];
$user_id = null;
if (isset($_SESSION['name'])) {
    $user_data['name'] = $_SESSION['name'];
    $user_data['email'] = $_SESSION['email'];
    $user_id = $_SESSION['id_user'];
}

// Обработка формы обратной связи
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $comment = $_POST['message'];
    $id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : NULL;

    // Вставка данных в таблицу connection
    $stmt = $conn->prepare("INSERT INTO connection (name, email, comment, id_user) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("sssi", $name, $email, $comment, $id_user);

    if ($stmt->execute()) {
        $success = "Сообщение успешно отправлено.";
    } else {
        $error = "Ошибка при отправке сообщения: " . htmlspecialchars($stmt->error);
    }
    $stmt->close();
}
?>

<!doctype html>
<html lang="en,ru">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="public/logo_E&L_title.svg" width="auto"/>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;700&family=Lavishly+Yours&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Eternal Lovers</title>
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
          <a href="favorite.php" class="header__icon"><img src="public/icon/ph_heart-thin.svg" alt="Favorite"></a>
          <a href="basket.php" class="header__icon"><img src="public/icon/ph_basket-thin.svg" alt="Basket"></a>
          <?php if (isset($_SESSION['name'])); ?>
            <a href="profile.php" class="header__icon">
              <img src="public/icon/iconamoon_profile-light.svg" alt="Profile">
              <?php echo $_SESSION['name'] ?>
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
    <section id="contacts" class="contacts">
        <h2 class="contacts__title">Контакты</h2>
        <div class="contacts__content">
            <div class="contacts__info">
                <p class="contacts__phone">8 800 888 88 88</p>
                <p class="contacts__hours">Работаем с 10:00 до 20:00</p>
                <p class="contacts__address">117149, г. Москва, ул. Нежинская, д. 7, кв. 1</p>
                <p class="contacts__metro">Метро "Славянский бульвар" или "Минская"</p>
                <p class="contacts__email"><img src="public/icon/material-symbols-light_mail-outline.svg" alt=""><a href="mailto:info@eternal-lovers.ru">info@eternal-lovers.ru</a></p>
            </div>
            <div class="contacts__map">
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A44c6b645c7fe8e9a634de2502af894d663d5f6217f56aa61a7a95432fa843392&amp;source=constructor" width="570px" height="570px" frameborder="0"></iframe>
            </div>
        </div>
    </section>
    <section id="consultation" class="consultation feedback">
        <h2 class="consultation__title feedback__title">Обратная связь</h2>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        <form class="consultation__form feedback__form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="text" class="consultation__input feedback__input" name="name" placeholder="Имя" value="<?php echo isset($user_data['name']) ? htmlspecialchars($user_data['name']) : ''; ?>" required>
            <input type="email" class="consultation__input feedback__input" name="email" placeholder="Mail" value="<?php echo isset($user_data['email']) ? htmlspecialchars($user_data['email']) : ''; ?>" required>
            <textarea class="consultation__textarea feedback__textarea" name="message" placeholder="Введите ваше сообщение" required></textarea>
            <button type="submit" class="consultation__button feedback__button">Отправить</button>
        </form>
    </section>  
    <footer class="footer">
      <div class="footer__container">
        <div class="footer__logo">
          <img src="public/logo_E&L_title.svg" alt="Eternal Lovers">
        </div>
        <nav class="footer__nav">
            <ul class="footer__nav-list">
              <li class="footer__nav-item"><a href="catalog.php" class="footer__nav-link">Каталог</a></li>
              <li class="footer__nav-item"><a href="index.php#consultation" class="footer__nav-link">Консультация</a></li>
              <li class="footer__nav-item"><a href="index.php#services" class="footer__nav-link">Услуги</a></li>
            </ul>
            <ul class="footer__nav-list">
              <li class="footer__nav-item"><a href="index.php#about" class="footer__nav-link">О нас</a></li>
              <li class="footer__nav-item"><a href="blog.php" class="footer__nav-link">Блог</a></li>
              <li class="footer__nav-item"><a href="portfolio.php" class="footer__nav-link">Портфолио</a></li>
              <li class="footer__nav-item"><a href="reviews.php" class="footer__nav-link">Отзывы</a></li>
            </ul>
        </nav>
        <div class="footer__socials">
          <a href="#" class="footer__social-link"><img src="public/icon_social-media/streamline_instagram-solid.svg" alt="Instagram"></a>
          <a href="#" class="footer__social-link"><img src="public/icon_social-media/ic_baseline-telegram.svg" alt="Telegram"></a>
          <a href="#" class="footer__social-link"><img src="public/icon_social-media/mingcute_vkontakte-fill.svg" alt="VK"></a>
        </div>
        <div class="footer__contacts">
          <p class="footer__contacts-phone">8 800 888 88 88</p>
          <p class="footer__contacts-hours">Работаем с 10:00 до 20:00</p>
          <p class="footer__contacts-address">117149, г. Москва, ул. Нежинская, д. 7, кв. 1</p>
          <p class="footer__contacts-metro">Метро "Славянский бульвар" или "Минская"</p>
          <p class="footer__contacts-email"><img src="public/icon/material-symbols-light_mail-outline.svg" alt=""><a href="mailto:info@eternal-lovers.ru">info@eternal-lovers.ru</a></p>
        </div>
        <div class="footer__copyright">
          <p class="footer__copyright-text">© 2024 "Eternal Lovers"</p>
        </div>
      </div>
    </footer>
  </body>
</html>